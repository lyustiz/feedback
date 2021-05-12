<?php

namespace App\Http\Controllers;

use App\Models\PasswordResets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordResetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //index
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //store
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PasswordResets  $passwordResets
     * @return \Illuminate\Http\Response
     */
    public function show(PasswordResets $passwordResets)
    {
        //show
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PasswordResets  $passwordResets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PasswordResets $passwordResets)
    {
        //update
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PasswordResets  $passwordResets
     * @return \Illuminate\Http\Response
     */
    public function destroy(PasswordResets $passwordResets)
    {
        //destroy
    }
}
