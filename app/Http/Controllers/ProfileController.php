<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Agency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Profile::with(['profileProgress'])
                        ->withSum(['userProfile'], 'goal_day')  
                        ->withSum(['userProfile'], 'goal_month')  
                        ->orderBy('name')
                        ->get();
    }

    public function list()
    {
        return Profile::orderBy('name')->get();
    }

    public function profileAll()
    {
        $profiles = Profile::with([  'presence:id,start_at,user_id,profile_id', 'presence', 'agency:agency.id,amolatina_id,name', 
                                'usersProfileAssigned', 'presenceDay', 'userHasPresenceDay.table:table.id,name,value', 'userHasPresenceDay.turn:turn.id,name,turn.color,turn.icon'
                            ])
                        ->withSum(['presenceDay', 'presenceMonth'], 'bonus')
                        ->withSum(['presenceDay', 'presenceMonth'], 'writeoff')
                        ->orderBy('profile.agency_id', 'asc' )
                        ->orderBy('profile.name', 'asc' )
                        ->get();

        foreach ($profiles as $key => $profile) {
            $profiles[$key]['events'] = [ 'introductory' => 0, 'letter'=> 0, 'online' => 0 ];
        }

        return $profiles;
    }

    public function profilesEvents(Request $request)
    {
        $user   = \Auth::user()->load([ 'agencyManage:agency.id,name,amolatina_id,token,agency.goal_day,agency.goal_month']);
        $events = [];

        foreach ($user->agencyManage as $agency) {
            $setup  = Amolatina::getSetup('profile-events');
            $url    = $setup->url . '/' . $agency->amolatina_id . $setup->urlAdd;
            $response = Amolatina::getDataUrl( $agency->token, $url,  $setup->params, $setup->header);

            if($response['ok']) {
                $events[$agency->name] = $response['body'];
            } 
        }
        return $this->formatEvents($events);
    }

    public function formatEvents($agencyEvents = [])
    {
        $totalEvents = ['letter' => 0, 'introductory' => 0, 'online' => 0,];
        $profileEvents = [];    
        foreach ($agencyEvents as $dataEvents) {
            
            for ($i=0; $i < count($dataEvents['users']); $i++) { 
               $id     = $dataEvents['users-details'][$i]['id'];
               $online = $dataEvents['users-details'][$i]['presence'];   
               $event  = $dataEvents['users'][$i]['events'];  
               $event['online'] = $online;
               $totalEvents['letter']       += (isset($event['letter'])) ? $event['letter']['fresh'] : 0;
               $totalEvents['introductory'] += (isset($event['introductory'])) ? $event['introductory']['fresh'] : 0;
               $totalEvents['online']       += (isset($event['online'])) ? $event['online'] : 0;      
               $profileEvents[$id] =  $event; 
            }
        }
        return ['totalEvents'=> $totalEvents, 'profileEvents' => $profileEvents];
    }


    public function profileUser($userId)
    {
        return Profile::with([  'presence:id,start_at,user_id,profile_id', 'presence.user:id,name,surname', 'agency:agency.id,amolatina_id', 
                                'userProfileAssigned' => function($query) use ( $userId ) {
                                    $query->where('user_id', $userId);
                                },
                            ])
                        ->whereHas('user', function (Builder $query) use ($userId) {
                            $query->where('user.id', $userId);
                        })
                        ->withSum([
                            'presenceDay' => function (Builder $query)  use ($userId) {
                                $query->where('user_id', $userId);
                            },
                        ], 'bonus')
                        ->withSum([
                            'presenceDay' => function (Builder $query)  use ($userId) {
                                $query->where('user_id', $userId);
                            },
                        ], 'writeoff')
                        ->get();
    }

    public function profileTable($tableId)
    {
        $user = \Auth::user();

        return Profile::with(['presence', 'presence.user:id,name,surname', 'agency:agency.id,amolatina_id'])
                        ->whereHas('user', function (Builder $query) use($tableId) {
                            $query->where('user.table_id', $tableId);
                        })
                        ->whereDoesntHave('userProfile', function (Builder $query) use($user) {
                            $query->where('user_id', $user->id);
                        })
                        ->withSum([ 'presenceDay' ], 'bonus')
                        ->withSum([ 'presenceDay' ], 'writeoff')
                        ->get();
    }

    public function profileCoordinator()
    {
        $user = \Auth::user();

        return Profile::with(['presence', 'presence.user:id,name,surname', 'agency:agency.id,amolatina_id'])
                        ->whereHas('user', function (Builder $query) use($user) {
                            $query->where('user.table_id', $user->table_id);
                        })
                        ->whereDoesntHave('userProfile', function (Builder $query) use($user) {
                            $query->where('user_id', $user->id);
                        })
                        ->withSum([ 'presenceDay' ], 'bonus')
                        ->withSum([ 'presenceDay' ], 'writeoff')
                        ->get();
    }

    public function profileImport(Request $request, Agency $agency)
    {
        set_time_limit ( 300 );

        $profiles = Profile::where('agency_id' , $agency->id)->get()->pluck('amolatina_id')->toArray();

        $response = $this->getAgencyProfiles($agency->token, $agency->amolatina_id);

        if($response['ok'])
        {
            $newProfiles = $response['body']['users'];

            return $this->storeProfiles($profiles, $newProfiles, $agency);
        }
    }

    public function getAgencyProfiles($token, $amolatinaId)
    {
        $setup          = Amolatina::getSetup('agency-profiles');
        $url            = $setup->url . '/' . $amolatinaId . '/descendants' ;
        $params         = $setup->params;
        return Amolatina::getDataUrl( $token, $url, $params );
    }
    
    public function getDetailProfile($token, $amolatinaId)
    {
        $setup          = Amolatina::getSetup('detail-profile');
        $url            = $setup->url . '/' . $amolatinaId  ;
        return Amolatina::getDataUrl( $token, $url );
    }

    public function storeProfiles($profiles, $newProfiles, $agency)
    {
        $storeProfiles = [];
        foreach ($newProfiles as $newProfile) {
            if(in_array($newProfile['user-id'], $profiles))
            {
                continue;
            }

            $response = $this->getDetailProfile($agency->token, $newProfile['user-id']);

            if($response['ok'])
            {
                $profileDetail = $response['body'];

                $storeProfiles[] = $this->setDataProfile($newProfile, $profileDetail, $agency);
            }
        }

        $insert = Profile::insert($storeProfiles);

        return ['msj' => 'se importaron (' . count($storeProfiles) . ') perfiles', 'insert' => $insert ];
    }

    public function setDataProfile($newProfile, $profileDetail, $agency)
    {
        return   $data = [
            'agency_id'    => $agency->id,
            'amolatina_id' => $profileDetail['id'],
            'name'         => $profileDetail['name'],
            'birthday'     => (isset($profileDetail['birthday'])) ?  Carbon::parse($profileDetail['birthday'])->format('Y-m-d') : null,
            'age'          => (isset($newProfile['age'])) ? $newProfile['age'] : null,
            'photo'        => (isset($newProfile['thumbnail'])) ? $newProfile['thumbnail'] : null,
            'gender'       => (isset($profileDetail['gender'])) ? $profileDetail['gender'] : null,
            'country'      => (isset($profileDetail['country'])) ? $profileDetail['country'] : null,
            'city'         => (isset($profileDetail['city'])) ? $profileDetail['city'] : null,
            'status_id'    => 1,
            'user_id'      => 1,
            'created_at'   => date('Y-m-d'),
        ];
    }


    public function importProfilePhoto()
    {
        set_time_limit ( 300 );

        $profiles = Profile::with(['agency'])->whereNull('updated_at')->whereNotNull('photo')->get();

        $stored = [];
        foreach ($profiles as $profile) {
            $stored[$profile->id] = $this->getPhotoProfile($profile);
        }

        return $stored;
    }

    public function getPhotoProfile($profile)
    {
        $token       = $profile->agency->token;
        $response    = $this->getPhoto($token, $profile);
         
        if($response['ok'])
        {
            $file = $response['body'];
            return  $this->storePhoto($file, "$profile->photo.jpg", 'photo_profile'); 
        }
        return false;
    }

    public function getPhoto($token, $profile)
    {
       $photo    =  "$profile->photo.215x180.thumb-fd";
       $url      = "users/".$profile->amolatina_id."/photos/$photo";
       return    Amolatina::getContentUrl($token, $url, 'https://api4.amolatina.com/');
    }

    public function storePhoto($fileContend, $fileName, $storage)
    {
        return Storage::disk($storage)->put( $fileName, $fileContend);
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
            'amolatina_id'      => 	'required|string|max:',
			'name'              => 	'required|string|max:60',
			'birthday'          => 	'required|string|max:0',
			'age'               => 	'required|integer|max:999999999',
			'photo'             => 	'required|string|max:200',
			'gender'            => 	'required|string|max:3',
			'preference'        => 	'required|string|max:3',
			'country'           => 	'required|string|max:3',
			'city'              => 	'required|string|max:100',
			'minage'            => 	'required|integer|max:999999999',
			'maxage'            => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:800',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $profile = profile::create($request->all());

        return [ 'msj' => 'Profile Agregado Correctamente', compact('profile') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return $profile;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $validate = request()->validate([
            'amolatina_id'      => 	'required|string|max:',
			'name'              => 	'required|string|max:60',
			'birthday'          => 	'required|string|max:0',
			'age'               => 	'required|integer|max:999999999',
			'photo'             => 	'required|string|max:200',
			'gender'            => 	'required|string|max:3',
			'preference'        => 	'required|string|max:3',
			'country'           => 	'required|string|max:3',
			'city'              => 	'required|string|max:100',
			'minage'            => 	'required|integer|max:999999999',
			'maxage'            => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:800',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $profile = $profile->update($request->all());

        return [ 'msj' => 'Profile Editado' , compact('profile')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile = $profile->delete();
 
        return [ 'msj' => 'Profile Eliminado' , compact('profile')];
    }
}
