<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Menu::with([])
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
            'name'              => 	'required|string|max:30',
			'label'             => 	'nullable|string|max:30',
			'component'         => 	'nullable|string|max:30',
			'path'              => 	'nullable|string|max:80',
			'icon'              => 	'nullable|string|max:50',
			'color'             => 	'nullable|string|max:50',
			'hidden'            => 	'nullable|boolean',
			'module_id'         => 	'nullable|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $menu = menu::create($request->all());

        return [ 'msj' => 'Menu Agregado Correctamente', compact('menu') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return $menu;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:30',
			'label'             => 	'nullable|string|max:30',
			'component'         => 	'nullable|string|max:30',
			'path'              => 	'nullable|string|max:80',
			'icon'              => 	'nullable|string|max:50',
			'color'             => 	'nullable|string|max:50',
			'hidden'            => 	'nullable|boolean',
			'module_id'         => 	'nullable|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $menu = $menu->update($request->all());

        return [ 'msj' => 'Menu Editado' , compact('menu')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu = $menu->delete();
 
        return [ 'msj' => 'Menu Eliminado' , compact('menu')];
    }
}
