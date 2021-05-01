<?php

namespace App\Http\Controllers;

use App\Models\ProfileProgress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
