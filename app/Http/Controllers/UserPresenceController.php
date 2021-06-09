<?php

namespace App\Http\Controllers;

use App\Models\UserPresence;
use App\Models\Profile;
use App\Models\Comission;
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

    public function presenceUserProfile($userId, $profileId)
    {
        return UserPresence::with([])
                    ->where('user_id', $userId)
                    ->where('profile_id', $profileId)
                    ->whereBetween('start_at', [ Carbon::now()->startOfDay(), Carbon::now()->endOfDay() ])
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

        $profiles = Profile::whereIn('id', $request->profiles_id)->doesntHave('presence')->get();

        $userPresence = [];

        foreach ($profiles as $profile) {

            $userPresence[] = [
                'user_id'      => $request->user_id,
                'profile_id'   => $profile->id,
                'amolatina_id' => $profile->amolatina_id,
                'start_at'     => Carbon::now('UTC')->toDateTimeLocalString('millisecond'),
                'active'       => 1,
                'status_id'    => 3,
                'user_id_ed'   => $request->user_id,
                'created_at'   => date("Y-m-d H:i:s")
            ];
        }

        if(count($userPresence) < 1)
        {
            throw ValidationException::withMessages(['error' => 'Perfil(es) no Disponibles' ]);
        }

        $insert = UserPresence::insert($userPresence);

        return [ 'msj' => 'Perfil(es) Iniciado(s)', 'userPresence' => $userPresence, 'insert' => $insert ];
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

    public function stopUnique(Request $request)
    {
        $validate = request()->validate([
            'user_presence_id' => 'required|integer|max:999999999',
            'user_id'          => 'required|integer|max:999999999',
        ]);

        $end_at = Carbon::now('UTC')->toDateTimeLocalString('millisecond');

        $estimate = \DB::select( \DB::raw("SELECT total.id, 
                                            SUM(IF(total.positive=0, total.points, 0)) write_off, 
                                            SUM(IF(total.positive=1, total.points, 0)) points, 
                                            SUM(total.share) share, 
                                            SUM(total.profit) profit
                                    FROM ( SELECT up.id, c.positive, c.points, c.share, c.profit 
                                             FROM comission c
                                             JOIN user_presence up ON up.amolatina_id = c.profile_id
                                            WHERE c.comission_at > up.start_at
                                              AND up.id = :user_presence_id) total
                                    GROUP BY total.id"), 
                                    array('user_presence_id' => $request->user_presence_id)
                                    );
        
        $userPresence = UserPresence::find($request->user_presence_id)->update([
                                    'bonus'     => isset($estimate[0]) ? $estimate[0]->points : 0,
                                    'writeoff'  => isset($estimate[0]) ? $estimate[0]->write_off : 0,
                                    'shared'    => isset($estimate[0]) ? $estimate[0]->share : 0,
                                    'profit'    => isset($estimate[0]) ? $estimate[0]->profit : 0,
                                    'end_at'    => $end_at,
                                    'comments'  => 'stop unique',
                                    'active'    => 0,
                                    'status_id' => 4,
                                    ]);

        if( $userPresence == null )
        {
            throw ValidationException::withMessages(['error' => 'Perfil no Disponible' ]);
        }                                           
                                    
        return [ 'msj' => 'Perfil Finalizado' , compact('userPresence')];
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
        ]);

        $estimates = \DB::select( \DB::raw("SELECT total.id, 
                                    SUM(IF(total.positive=0, total.points, 0)) write_off, 
                                    SUM(IF(total.positive=1, total.points, 0)) points, 
                                    SUM(total.share) share, 
                                    SUM(total.profit) profit
                               FROM (SELECT up.id, c.positive, c.points, c.share, c.profit 
                                       FROM comission c
                                       JOIN profile p ON p.amolatina_id = c.profile_id
                                       JOIN user_presence up ON p.id = up.profile_id
                                      WHERE c.comission_at > up.start_at
                                        AND up.status_id = 3
                                        AND up.user_id = :user_id) total
                               GROUP BY total.id"), 
                             array('user_id' => $request->user_id 
                          )
                  );

         $end_at = Carbon::now('UTC')->toDateTimeLocalString('millisecond');

         $updates = []; 

         foreach ($estimates as $estimate) {

            $updates[$estimate->id] = UserPresence::find($estimate->id)->update([
                                            'bonus'      => $estimate->points,
                                            'writeoff'   => $estimate->write_off,
                                            'shared'     => $estimate->share,
                                            'profit'     => $estimate->profit,
                                            'end_at'     => $end_at,
                                            'comments'   => 'stop',
                                            'active'     => 0,
                                            'status_id'  => 4,
                                        ]);
         }

         $others = UserPresence::where('user_id', $request->user_id)->where('status_id', 3)->update([
                                    'end_at'     => $end_at,
                                    'comments'   => 'stop',
                                    'active'     => 0,
                                    'status_id'  => 4,
                                ]);

         return [ 'msj' => 'Perfiles Finalizados' , compact('updates')];

    }

    public function presenceEstimate()
    {
        set_time_limit ( 300 );
        
        $searches = UserPresence::select('user_presence.start_at', 'agency.amolatina_id', 'agency.name', 'agency.token')
                                 ->join('profile', 'profile.id', '=', 'user_presence.profile_id')
                                 ->join('agency', 'agency.id', '=', 'profile.agency_id')
                                 ->where('user_presence.status_id', 3)
                                 ->distinct()
                                 ->dd();

        $userPresences = UserPresence::with(['profile:profile.id,amolatina_id,name', 'profile.agency:agency.id,amolatina_id'])
                                     ->where( 'status_id' , 3)
                                     ->get();


        $end_at = Carbon::now('UTC')->toDateTimeLocalString('millisecond');
        
        $updates = [];

        foreach ($searches as $search) {
            
            $response = $this->getProfileCommisions($search->token, $search->amolatina_id, $search->start_at, $end_at);

            if($response['ok'])
            {
                $commissions = $response['body']['commissions'];

                $updates[$search->name][$search->start_at] = $this->setPrecenseCommisions($userPresences, $commissions, $search->start_at, $end_at, false);

            } else {

                $updates[$search->name][$search->start_at] = ['error'];

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

    public function setPrecenseCommisions($userPresences, $commissions, $startAt, $endAt,  $stop = false)
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

                if( $commission['user-id'] == $amolatina_id  &&  $startAt == $userPresence->start_at)
                {
                    $totals[ 'bonus' ]    = $totals[ 'bonus' ]    + (($commission['positive']) ? $commission['points'] : 0) ; 
                    $totals[ 'writeoff' ] = $totals[ 'writeoff' ] + ((!$commission['positive']) ? $commission['points'] : 0) ; 
                    $totals[ 'shared' ]   = $totals[ 'shared' ]   + $commission['share'];
                    $totals[ 'profit' ]   = $totals[ 'profit' ]   + $commission['profit'];
                    $totals[ 'comments' ] = 'manually';
                }
            }

            if(isset($totals[ 'comments' ]))
            {
                $updates[$userPresence->id . '-' . $amolatina_id] = $userPresence->update($totals);

                $updates[$userPresence->id . '-' . $amolatina_id] = $totals;
            }

            if($stop)
            {
                $stopPrecense = [
                    'status_id' => 4,
                    'active'    => 0,
                    'end_at'    => $endAt,
                    'comments'  => 'stop'
                ];

                $userPresence->update($stopPrecense);
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
