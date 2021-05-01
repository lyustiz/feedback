<?php

namespace App\Http\Controllers;

use App\Models\UserProgress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserProgress::with([])
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
			'progress_day'      => 	'required|numeric|max:9',
			'progress_month'    => 	'required|numeric|max:9',
			'progress_total'    => 	'required|numeric|max:9',
			'progress_max_day'  => 	'required|numeric|max:9',
			'progress_max_month'=> 	'required|numeric|max:9',
			'rank'              => 	'required|integer|max:999999999',
			'milestone_day'     => 	'required|integer|max:999999999',
			'milestone_month'   => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $userProgress = userProgress::create($request->all());

        return [ 'msj' => 'UserProgress Agregado Correctamente', compact('userProgress') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserProgress  $userProgress
     * @return \Illuminate\Http\Response
     */
    public function show(UserProgress $userProgress)
    {
        return $userProgress;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserProgress  $userProgress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserProgress $userProgress)
    {
        $validate = request()->validate([
            'user_id'           => 	'required|integer|max:999999999',
			'progress_day'      => 	'required|numeric|max:9',
			'progress_month'    => 	'required|numeric|max:9',
			'progress_total'    => 	'required|numeric|max:9',
			'progress_max_day'  => 	'required|numeric|max:9',
			'progress_max_month'=> 	'required|numeric|max:9',
			'rank'              => 	'required|integer|max:999999999',
			'milestone_day'     => 	'required|integer|max:999999999',
			'milestone_month'   => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $userProgress = $userProgress->update($request->all());

        return [ 'msj' => 'UserProgress Editado' , compact('userProgress')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProgress  $userProgress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProgress $userProgress)
    {
        $userProgress = $userProgress->delete();
 
        return [ 'msj' => 'UserProgress Eliminado' , compact('userProgress')];
    }
}
