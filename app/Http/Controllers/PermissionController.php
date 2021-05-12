<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Permission::with([])
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
            'role_id'            => 	'nullable|integer|max:999999999',
			'menu_id'           => 	'nullable|integer|max:999999999',
			'sel'               => 	'nullable|boolean',
			'ins'               => 	'nullable|boolean',
			'upd'               => 	'nullable|boolean',
			'del'               => 	'nullable|boolean',
			'adm'               => 	'nullable|boolean',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $permission = permission::create($request->all());

        return [ 'msj' => 'Permission Agregado Correctamente', compact('permission') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return $permission;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $validate = request()->validate([
            'role_id'            => 	'nullable|integer|max:999999999',
			'menu_id'           => 	'nullable|integer|max:999999999',
			'sel'               => 	'nullable|boolean',
			'ins'               => 	'nullable|boolean',
			'upd'               => 	'nullable|boolean',
			'del'               => 	'nullable|boolean',
			'adm'               => 	'nullable|boolean',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $permission = $permission->update($request->all());

        return [ 'msj' => 'Permission Editado' , compact('permission')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission = $permission->delete();
 
        return [ 'msj' => 'Permission Eliminado' , compact('permission')];
    }
}
