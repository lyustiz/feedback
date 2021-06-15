<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserProfile::with([])
                    ->get();
    }

    public function assing($userId, $agencyId)
    {
        $userProfile = UserProfile::select('id','user_id','profile_id','agency_id','goal_day','goal_month')
                                        ->with(['profile:id,name,photo,gender,amolatina_id', 'agency:id,name'])
                                        ->where('user_id', $userId)
                                        ->get();

        $profile     = Profile::select('id','name', 'photo', 'gender', 'amolatina_id', 'agency_id')
                                ->with(['agency:id,name'])
                                ->whereNotIn('profile.id', $userProfile->pluck('profile_id'))
                                ->orderBy('profile.name', 'asc')
                                ->get();

        $userProfile = $this->formatProfiles($userProfile);

        return [ 'userProfiles' => $userProfile, 'profiles' => $profile] ;
    }


    function formatProfiles($data)
    {
        $userProfile = [];
        
        foreach ($data as $key => $row) {
            $userProfile[] = [
                'id'           => $row->id,
                'profile_id'   => $row->profile_id,
                'name'         => $row->profile->name,
                'photo'        => $row->profile->photo,
                'gender'       => $row->profile->gender,
                'amolatina_id' => $row->profile->amolatina_id,
                'agency_id'    => $row->profile->agency_id,
                'goal_day'     => $row->goal_day,
                'goal_month'   => $row->goal_month,
            ];
        }

        return $userProfile;
    }

    function formatProfile($data)
    {
        return [
                'id'            => $data->id,
                'profile_id'    => $data->profile_id,
                'name'          => $data->profile->name,
                'photo'         => $data->profile->photo,
                'gender'        => $data->profile->gender,
                'amolatina_id'  => $data->profile->amolatina_id,
                'agency_id'     => $data->profile->agency_id,
            ];
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
            'agency_id'         => 	'required|integer|max:999999999',
			'profile_id'        => 	'required|numeric|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $userProfile = UserProfile::create($request->all());

        $userProfile->load(['profile:id,name,photo,gender,amolatina_id']);

        return [ 'msj' => 'Profile Agregado Correctamente', 'userProfile' => $this->formatProfile($userProfile) ];
    }

    public function storeAll(Request $request)
    {
        $validate = request()->validate([
            'user_id'      => 'required|integer|max:999999999',
            'agency_id'    => 'required|integer|max:999999999',
			'profiles_id'  => 'required|array',
			'comments'     => 'nullable|string|max:100',
			'status_id'    => 'required|integer|max:999999999',
			'user_id_ed'   => 'required|integer|max:999999999',
        ]);

        $profiles = Profile::select('id')
                    ->whereNoHas('userProfile', function (Builder $query) use($request) {
                        $query->where('user_id', $request->user_id);
                    })
                    ->where('agency_id', $request->agency_id)
                    ->get();

        $userProfiles = [];

        foreach ($profiles as $profile) {
            $userProfiles[] = [
                'user_id'    => $request->user_id,
                'profile_id' => $profile->id,
                'agency_id'  => $request->agency_id,
                'status_id'  => 1,
                'user_id_ed' => $request->user_id_ed
            ];
        }
        
        $inserts = UserProfile::insert($userProfiles);

        return [ 'msj' => 'Profiles Agregados Correctamente', 'ins' => $inserts ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function show(UserProfile $userProfile)
    {
        return $userProfile;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserProfile $userProfile)
    {
        $validate = request()->validate([
            'goal_day'   => 'required|integer|max:999999999',
            'goal_month' => 'required|integer|max:999999999',
			'user_id_ed' => 'required|integer|max:999999999',
        ]);

        $userProfile = $userProfile->update($request->all());

        return [ 'msj' => 'Metas Actualizadas' , compact('userProfile')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProfile $userProfile)
    {
        $userProfile = $userProfile->delete();
 
        return [ 'msj' => 'Profile Eliminado' , compact('userProfile')];
    }
}
