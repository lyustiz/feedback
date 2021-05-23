<?php

namespace App\Http\Controllers;

use App\Models\ProfileProgress;
use App\Models\Agency;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;

class ProfileProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProfileProgress::with([])
                    ->get();
    }

    public function getProgress()
    {
        
        $agencies = Agency::select('id', 'amolatina_id', 'token')->get();  //TODO ALL AGENCIES

        $this->setProfiles();

        $updates = [];

        foreach ($agencies as $agency) {
            
            $token        = $agency->token;

            $amolatina_id = $agency->amolatina_id;

            $response = $this->getProfileCommisions($token, $amolatina_id, 'month');

            if($response['ok'])
            {
                $commissions = $response['body']['commissions'];

                $updates[] = $this->setProfileProgress($commissions, 'month');
            }

            $response = $this->getProfileCommisions($token, $amolatina_id, 'day');

            if($response['ok'])
            {
                
                $commissions = $response['body']['commissions'];

                $updates[] = $this->setProfileProgress($commissions, 'day');
            }
        }

        return $updates;
    }

    public function setProfiles()
    {
        $profiles  = Profile::where('status_id', 1)->doesntHave('profileProgress')->get();
        $insert    = [];  

        foreach ($profiles as $profile) {
            $insert[] = [
                'profile_id'   => $profile->id,
                'amolatina_id' => $profile->amolatina_id, 
                'user_id'      => $profile->user_id, 
                'status_id'    => $profile->status_id
            ];
        }
        return ProfileProgress::insert($insert);
    }

    public function getProfileCommisions($token, $amolatinaId, $type)
    {
        $range          = Amolatina::dateRange($type);
        $setup          = Amolatina::getSetup('credits-profile');
        $url            = $setup->url . '/' . $amolatinaId;
        $params         = $setup->params;
        $params['from'] = $range->from;
        $params['to']   = $range->to;
        $header         = $setup->header;
        return   Amolatina::getDataUrl( $token, $url, $params, $header);
    }

    public function setProfileProgress($commissions, $type)
    {
        foreach ($commissions as $commission) {

            $updates = [];
            if(isset($commission['user-id']))
            {
                
                if($type == 'month')
                {
                    $totals = ( $commission['positive'] == 'true' ) 
                          ? ['profit_month'   => $commission['profit'], 'points_month' => $commission['points'] ] 
                          : ['writeoff_month' => $commission['points']];

                } else {
                    $totals = ( $commission['positive'] == 'true' ) 
                          ? ['profit_day'   => $commission['profit'], 'points_day' => $commission['points']] 
                          : ['writeoff_day' => $commission['points']];
                }

                $updates[]  = ProfileProgress::where('amolatina_id',  $commission['user-id'] )->update($totals);
            }
        }
        return $updates;
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
            'profile_id'        => 	'required|integer|max:999999999',
			'progress_day'      => 	'required|numeric|max:9',
			'progress_month'    => 	'required|numeric|max:9',
			'progress_total'    => 	'required|numeric|max:9',
			'progress_max_day'  => 	'required|numeric|max:9',
			'progress_max_month'=> 	'required|numeric|max:9',
			'crowns'            => 	'required|integer|max:999999999',
			'hearts'            => 	'required|integer|max:999999999',
			'milestone_day'     => 	'required|integer|max:999999999',
			'milestone_month'   => 	'required|integer|max:999999999',
			'task_mails'        => 	'required|integer|max:999999999',
			'task_photos'       => 	'required|integer|max:999999999',
			'task_videos'       => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $profileProgress = profileProgress::create($request->all());

        return [ 'msj' => 'ProfileProgress Agregado Correctamente', compact('profileProgress') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfileProgress  $profileProgress
     * @return \Illuminate\Http\Response
     */
    public function show(ProfileProgress $profileProgress)
    {
        return $profileProgress;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfileProgress  $profileProgress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfileProgress $profileProgress)
    {
        $validate = request()->validate([
            'profile_id'        => 	'required|integer|max:999999999',
			'progress_day'      => 	'required|numeric|max:9',
			'progress_month'    => 	'required|numeric|max:9',
			'progress_total'    => 	'required|numeric|max:9',
			'progress_max_day'  => 	'required|numeric|max:9',
			'progress_max_month'=> 	'required|numeric|max:9',
			'crowns'            => 	'required|integer|max:999999999',
			'hearts'            => 	'required|integer|max:999999999',
			'milestone_day'     => 	'required|integer|max:999999999',
			'milestone_month'   => 	'required|integer|max:999999999',
			'task_mails'        => 	'required|integer|max:999999999',
			'task_photos'       => 	'required|integer|max:999999999',
			'task_videos'       => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $profileProgress = $profileProgress->update($request->all());

        return [ 'msj' => 'ProfileProgress Editado' , compact('profileProgress')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfileProgress  $profileProgress
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfileProgress $profileProgress)
    {
        $profileProgress = $profileProgress->delete();
 
        return [ 'msj' => 'ProfileProgress Eliminado' , compact('profileProgress')];
    }
}
