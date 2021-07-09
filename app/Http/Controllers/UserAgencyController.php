<?php

namespace App\Http\Controllers;

use App\Models\UserAgency;
use App\Models\Agency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserAgency::with([])
                    ->get();
    }

    public function assing($userId, $agencyId)
    {
        $userAgency = UserAgency::with(['agency:id,name'])
                                    ->select('id','user_id','agency_id')
                                    ->where('user_id', $userId)
                                    ->get();

        $agency     = Agency::select('id','name', 'amolatina_id')
                                ->whereNotIn('agency.id', $userAgency->pluck('agency_id'))
                                ->orderBy('agency.name', 'asc')
                                ->get();

        $userAgency = $this->formatData($userAgency);

        return [ 'userAgency' => $userAgency, 'agency' => $agency] ;
    }


    function formatData($data)
    {
        $userAgency = [];
        
        foreach ($data as $key => $row) {
            $userAgency[] = [
                'id'           => $row->id,
                'user_id'      => $row->user_id,
                'agency_id'    => $row->agency_id,
                'name'         => $row->agency->name,
            ];
        }

        return $userAgency;
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
			'agency_id'         => 	'nullable|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $userAgency = userAgency::create($request->all());

        return [ 'msj' => 'UserAgency Agregado Correctamente', 'userAgency' =>  $userAgency ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAgency  $userAgency
     * @return \Illuminate\Http\Response
     */
    public function show(UserAgency $userAgency)
    {
        return $userAgency;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAgency  $userAgency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAgency $userAgency)
    {
        $validate = request()->validate([
            'user_id'           => 	'required|integer|max:999999999',
			'agency_id'         => 	'nullable|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $userAgency = $userAgency->update($request->all());

        return [ 'msj' => 'UserAgency Editado' , compact('userAgency')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAgency  $userAgency
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAgency $userAgency)
    {
        $userAgency = $userAgency->delete();
 
        return [ 'msj' => 'UserAgency Eliminado' , compact('userAgency')];
    }
}
