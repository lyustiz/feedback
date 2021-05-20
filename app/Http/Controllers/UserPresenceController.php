<?php

namespace App\Http\Controllers;

use App\Models\UserPresence;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use App\Events\StopPresenceEvent;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;

class UserPresenceController extends Controller
{
    use Amolatina;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserPresence::with([])
                    ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = request()->validate([
            'user_id'           => 	'required|integer|max:999999999',
			'profiles_id'        => 'required|array',
        ]);

        $profilesStarted = $this->profilePrecense($request->profiles_id);

        $userPresence = [];

        foreach ($request->profiles_id as $profile_id) {
            if( !in_array($profile_id, $profilesStarted) )
            {
                $userPresence[] = [
                    'user_id'    => $request->user_id,
                    'profile_id' => $profile_id,
                    'start_at'   => Carbon::now('UTC')->toDateTimeLocalString('millisecond'), // date("Y-m-d H:i:s"), //check zona horaria
                    'active'     => 1,
                    'status_id'  => 3,
                    'user_id_ed' => $request->user_id,
                    'created_at' => date("Y-m-d H:i:s")
                ];
            }
        }

        if(count($userPresence) < 1)
        {
            throw ValidationException::withMessages(['error' => 'No existen perfiles Disponibles' ]);
        }

        $insert = UserPresence::insert($userPresence);

        return [ 'msj' => 'Perfiles Iniciados', 'userPresence' => $userPresence, 'insert' => $insert ];
    }

    public function profilePrecense($profiles)
    {
        return  UserPresence::select('profile_id')
                            ->whereIn('profile_id',  $profiles)
                            ->started(true)->get()->pluck('profile_id')->toArray();
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserPresence  $userPresence
     * @return \Illuminate\Http\Response
     */
    public function show(UserPresence $userPresence)
    {
        return $userPresence;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPresence  $userPresence
     * @return \Illuminate\Http\Response
     */
    public function stop(Request $request)
    {
        $validate = request()->validate([
            'user_id'        =>  'required|integer|max:999999999',
            'token'          =>  'required',
        ]);

        $userPresences = UserPresence::with(['profile:profile.id,amolatina_id', 'profile.agency:agency.id,amolatina_id'])
                                       ->where( ['user_id' =>  $request->user_id, 'status_id' => 3])
                                       ->get();

        $userPresencesId = $userPresences->pluck('id')->toArray();

        $end_at = Carbon::now('UTC')->toDateTimeLocalString('millisecond');

        $update = UserPresence::whereIn('id', $userPresencesId )
                                ->update([
                                    'status_id' => 4, 
                                    'active'    => 0,
                                    'end_at'    => $end_at,
                                ]);                    

        $this->stopPrecence($userPresences, $request->token, $end_at);
        
        //event(new StopPresenceEvent($userPresences)); 

        return [ 'msj' => 'Perfiles Finalizados' , compact('update')];
    }

    public function stopPrecence($userPresences, $token, $end_at)
    {  
        $start_at       = $userPresences->pluck('start_at')->first();
        $setup          = Amolatina::getSetup('credits-profile');
        $url            = $setup->url . '/' . '79602433731'; //TODO ARRAY FOREACH
        $params         = $setup->params;
        $params['from'] = Amolatina::formatDateTime($start_at);
        $params['to']   = Amolatina::formatDateTime($end_at);
        $header         = $setup->header;
        $response       = Amolatina::getDataUrl( $token, $url, $params, $header);
        
        if($response['ok'])
        {
            $commissions = $response['body']['commissions'];

            $updates = [];

            foreach ($userPresences as $userPresence) {

                $amolatina_id  = $userPresence->profile->amolatina_id; 

                $totals  =  [ 
                    'bonus'    => 0,
                    'writeoff' => 0,
                    'shared'   => 0,
                    'profit'   => 0,
                ];

                foreach ($commissions as $commission) {
                    
                    if( $commission['user-id'] == $amolatina_id )
                    {
                        $totals[ 'bonus' ]    =  $totals[ 'bonus' ]    + (($commission['positive']) ? $commission['points'] : 0) ; 
                        $totals[ 'writeoff' ] =  $totals[ 'writeoff' ] + ((!$commission['positive']) ? $commission['points'] : 0) ; 
                        $totals[ 'shared' ]   =  $totals[ 'shared' ]   + $commission['share'];
                        $totals[ 'profit' ]   =  $totals[ 'profit' ]   + $commission['profit'];
                    }
                }

                $updates[] = UserPresence::find($userPresence->id )->update($totals);
           }

        }

        return $updates;
    }

    public function presenceEstimate()
    {
        $searches = UserPresence::select('user_presence.start_at', 'agency.amolatina_id')
                                     ->join('profile', 'profile.id', '=', 'user_presence.profile_id')
                                     ->join('agency', 'agency.id', '=', 'profile.agency_id')
                                     ->where('user_presence.status_id', 3)
                                     ->distinct()
                                     ->get();

        $userPresences = UserPresence::with(['profile:profile.id,amolatina_id', 'profile.agency:agency.id,amolatina_id'])
                                     ->where( 'status_id' , 3)
                                     ->get();

        $end_at = Carbon::now('UTC')->toDateTimeLocalString('millisecond');
        $token  = '33568305-c77b-4719-a97e-331610a9b170';
        $updates = [];

        foreach ($searches as $search) {
            
            $response = $this->getProfileCommisions($token, $search->amolatina_id, $search->start_at, $end_at);

            if($response['ok'])
            {
                $commissions = $response['body']['commissions'];

                $updates[$search->amolatina_id][$search->start_at] = $this->setPrecenseCommisions($userPresences, $commissions, $search->start_at);
            } else {
                $updates[$search->amolatina_id][$search->start_at] =['error'];
            }
        }

        return $updates;
    }


    public function getProfileCommisions($token, $amolatinaId, $startAt, $endAt)
    {
        $setup          = Amolatina::getSetup('credits-profile');
        $url            = $setup->url . '/' . $amolatinaId;
        $params         = $setup->params;
        $params['from'] = Amolatina::formatDateTime($startAt);
        $params['to']   = Amolatina::formatDateTime($endAt);
        $header         = $setup->header;

        return   Amolatina::getDataUrl( $token, $url, $params, $header);
    }

    public function setPrecenseCommisions($userPresences, $commissions, $startAt)
    {
        $updates = [];
        
        foreach ($userPresences as $userPresence) {

            $amolatina_id  = $userPresence->profile->amolatina_id; 
    
            $totals  =  [ 
                'bonus'    => 0,
                'writeoff' => 0,
                'shared'   => 0,
                'profit'   => 0,
            ];
    
            foreach ($commissions as $commission) {
                
                if(!isset($commission['user-id']))
                {
                    continue;
                }

                if( $commission['user-id'] == $amolatina_id  &&  $startAt = $userPresence->start_at)
                {
                    $totals[ 'bonus' ]    =  $totals[ 'bonus' ]    + (($commission['positive']) ? $commission['points'] : 0) ; 
                    $totals[ 'writeoff' ] =  $totals[ 'writeoff' ] + ((!$commission['positive']) ? $commission['points'] : 0) ; 
                    $totals[ 'shared' ]   =  $totals[ 'shared' ]   + $commission['share'];
                    $totals[ 'profit' ]   =  $totals[ 'profit' ]   + $commission['profit'];
                    $totals[ 'comments' ] =  'manually';
                }
            }

            if(isset($totals[ 'comments' ]))
            {
                $updates[$amolatina_id] = UserPresence::find($userPresence->id )->update($totals);
            }

        }

        return  $updates;
    }

    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPresence  $userPresence
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPresence $userPresence)
    {
        $userPresence = $userPresence->delete();
 
        return [ 'msj' => 'UserPresence Eliminado' , compact('userPresence')];
    }
}
