<?php

namespace App\Http\Controllers;

use App\Models\FailedJobs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FailedJobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FailedJobs::with([])
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
            'uuid'              => 	'required|string|max:255',
			'connection'        => 	'required|string|max:65535',
			'queue'             => 	'required|string|max:65535',
			'payload'           => 	'required|string|max:0',
			'exception'         => 	'required|string|max:0',
			'failed_at'         => 	'required|date',
        ]);

        $failedJobs = failedJobs::create($request->all());

        return [ 'msj' => 'FailedJobs Agregado Correctamente', compact('failedJobs') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FailedJobs  $failedJobs
     * @return \Illuminate\Http\Response
     */
    public function show(FailedJobs $failedJobs)
    {
        return $failedJobs;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FailedJobs  $failedJobs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FailedJobs $failedJobs)
    {
        $validate = request()->validate([
            'uuid'              => 	'required|string|max:255',
			'connection'        => 	'required|string|max:65535',
			'queue'             => 	'required|string|max:65535',
			'payload'           => 	'required|string|max:0',
			'exception'         => 	'required|string|max:0',
			'failed_at'         => 	'required|date',
        ]);

        $failedJobs = $failedJobs->update($request->all());

        return [ 'msj' => 'FailedJobs Editado' , compact('failedJobs')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FailedJobs  $failedJobs
     * @return \Illuminate\Http\Response
     */
    public function destroy(FailedJobs $failedJobs)
    {
        $failedJobs = $failedJobs->delete();
 
        return [ 'msj' => 'FailedJobs Eliminado' , compact('failedJobs')];
    }
}
