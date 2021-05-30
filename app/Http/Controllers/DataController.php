<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Comission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;
use App\Models\UserPresence;



class DataController extends Controller
{
    use Amolatina;
    public $BASE_URL     = 'https://api.amolatina.com/';
    public $agency       = null;
    public $amolatinaId  = null;


    public function tokenName()
    {
        return 'token__' . $this->amolatinaId;
    }

    public function agencySetup($user)
    {
        $this->agency      = $user->agency;
        $this->amolatinaId = $this->agency->amolatina_id ;
    }

    public function index()
    {
        /* $this->agencySetup(Auth::user());
        
        $token = $this->getToken(); */
        $date = new Carbon;
        
        return $date->now()->toDateString();
/*
        promoter
realm

https://api.amolatina.com/users/19446624042/preferences

foto
ttps://api8.amolatina.com/users/19446624042/photos/09839839910dd03a.190x180.thumb-fd
                                                   09839839910dd03a

        clientes
        https://api.amolatina.com/users/80313661531/gateway?filter=photos&gender=fem&omit=0&preferences.gender=mal&search-token=925cc60dadb16cdd8413f0864040e0d7&select=15&sort=7
        filter: photos
        gender: fem
        omit: 0
        preferences.gender: mal
        search-token: 925cc60dadb16cdd8413f0864040e0d7
        select: 15
        sort: 7

        https://api.amolatina.com/users/81819250831/events?omit=0&select=20&types=%2Bletter


80313661531
        *
/
compartido curator
https://api.amolatina.com/credits/commissions/shares/79602433731/descendants/81541406531


ganancia perdida perfiles
accept: application/json+vnd.sdv.numeric
https://api.amolatina.com/credits/commissions/79602433731?from=2021-05-01T00%3A00%3A00.000Z&grouping%5B0%5D=userId&grouping%5B1%5D=positive&positive=true&to=2021-05-14T16%3A59%3A02.420Z
from: 2021-05-01T00:00:00.000Z
grouping[0]: userId
grouping[1]: positive
positive: true
to: 2021-05-14T16:59:02.420Z

perfiles ganancias resumen /**************** *
https://api.amolatina.com/credits/commissions/79602433731?from=2021-05-01T00%3A00%3A00.000Z&grouping%5B0%5D=userId&grouping%5B1%5D=positive&positive=true&to=2021-05-14T17%3A32%3A56.491Z
https://api.amolatina.com/credits/commissions/79602433731?from=2021-05-01T00%3A00%3A00.000Z&grouping%5B0%5D=userId&grouping%5B1%5D=positive&positive=true&to=2021-05-14T17%3A15%3A58.397Z
accept: application/json+vnd.sdv.numeric
from: 2021-05-01T00:00:00.000Z
grouping[0]: userId
grouping[1]: positive
positive: true
to: 2021-05-14T17:15:58.397Z

perdidas lista
https://api.amolatina.com/credits/commissions/79602433731?from=2021-05-01T00%3A00%3A00.000Z&omit=0&positive=false&select=50&to=2021-05-14T16%3A59%3A02.420Z
from: 2021-05-01T00:00:00.000Z
omit: 0
positive: false
select: 50
to: 2021-05-14T16:59:02.420Z

resumen perdidas
https://api.amolatina.com/credits/commissions/79602433731?from=2021-05-01T00%3A00%3A00.000Z&positive=false&to=2021-05-14T17%3A07%3A18.700Z
accept: application/json+vnd.sdv.numeric
from: 2021-05-01T00:00:00.000Z
positive: false
to: 2021-05-14T17:07:18.700Z


stadistica ganancias perdidas
https://api.amolatina.com/credits/commissions/stats/79602433731?agency-id=79602433731&date=2021-05&from=2021-05-01&to=2021-05-31
agency-id: 79602433731
date: 2021-05
from: 2021-05-01
to: 2021-05-31




        $url = 'credits/commissions/79602433731?from=2021-04-28T00%3A00%3A00.000Z&omit=0&positive=true&select=100&to=2021-04-28T23%3A17%3A07.050Z';
        //  users
        //photo "https://api7.amolatina.com/users/81845317731/photos/$photo.80x80.thumb-fd"
        //  $url = 'https://api.amolatina.com/users/hierarchy/79602433731/descendants?filter.suspended=false&filter.tags=%2Bp&omit=0&select=100';
        // presentes https://api.amolatina.com/presents/orders/overlords/79602433731/received
        // comision dia user https://api.amolatina.com/credits/commissions/79602433731?from=2021-04-01&grouping%5B0%5D=curatorId&grouping%5B1%5D=positive&positive=null&to=2021-05-01
        // comision agencia dia  https://api.amolatina.com/credits/commissions/79602433731?from=2021-04-30&to=2021-05-01
        // comision mes  https://api.amolatina.com/credits/commissions/79602433731?from=2021-04-01&to=2021-05-01
        // detalle ususario https://api.amolatina.com/users/81845317731?include=goods
        // presencia ususario https://api.amolatina.com/presence/81844280731
        // presentes https://www.amolatina.com/cp.web:19.1.0-rc.25/l10n/texts/presents/names
        // curador https://api.amolatina.com/users/hierarchy/80810380031
        // perfiles segun curador https://api.amolatina.com/users/hierarchy/80810380031
        // write of periodo  https://api.amolatina.com/credits/commissions/79602433731?from=2021-04-01T00%3A00%3A00.000Z&omit=0&positive=false&select=51&to=2021-04-30T00%3A00%3A00.000Z
        // write of resumen  https://api.amolatina.com/credits/commissions/79602433731?from=2021-04-01T00%3A00%3A00.000Z&positive=false&to=2021-04-30T00%3A00%3A00.000Z
        // https://api.amolatina.com/credits/commissions/79602433731?from=2021-02-01&grouping%5B0%5D=curatorId&grouping%5B1%5D=positive&positive=null&to=2021-03-01
        /*  from: 2021-02-01
            grouping[0]: curatorId
            grouping[1]: positive
            positive: null
            to: 2021-03-01

        
        message   Request URL: https://api.amolatina.com/dialogs/messages/77503126731:81819250831
        payload            {tag: 16205692539096646, text: "wqr"}
            tag: 16205692539096646
            text: "wqr"


        num send messages https://api.amolatina.com/users/80313661531/events?types=%2Bmessage
        list send mesasges https://api.amolatina.com/exo/streaming/identity/80313661531



            https://api.amolatina.com/users/hierarchy/79602433731/descendants?filter.suspended=false&filter.tags=%2Bp&omit=0&select=15
        */
        /*
        https://api.amolatina.com/credits/commissions/79602433731?from=2021-05-01T00%3A00%3A00.000Z&grouping%5B0%5D=userId&grouping%5B1%5D=positive&positive=true&to=2021-05-02T20%3A39%3A55.434Z
            from: 2021-05-01T00:00:00.000Z
            grouping[0]: userId
            grouping[1]: positive
            positive: true
            to: 2021-05-02T20:39:55.434Z
        https://api.amolatina.com/credits/commissions/79602433731?from=2021-05-01T00%3A00%3A00.000Z&omit=0&positive=true&select=51&to=2021-05-02T20%3A39%3A55.434Z
            from: 2021-05-01T00:00:00.000Z
            omit: 0
            positive: true
            select: 51
            to: 2021-05-02T20:39:55.434Z



        https://api.amolatina.com/users/81819250831/events?omit=0&select=25&types=%2Binvitation%2Binvitation.video%2Bmessage%2Brecommendation.letter
        omit: 0
        select: 25
        types: +invitation+invitation.video+message+recommendation.letter
        

        searc por localidad
        https://api.amolatina.com/users?country=CH&filter=photos&gender=fem&maxage=40&omit=0&preferences.gender=mal&q=1&search-token=5f0fa684e06e214fd04daf2fe07ca6a9&select=15&sort=7
        country: CH
        filter: photos
        gender: fem
        maxage: 40
        omit: 0
        preferences.gender: mal
        q: 1
        search-token: 5f0fa684e06e214fd04daf2fe07ca6a9
        select: 15
        sort: 7

        https://api9.amolatina.com/users/16238371942/photos/a0b79a6fa8032281.390x490.thumb-fd



        chat
        https://api.amolatina.com/events/79541745731  
        payload {"label":"event.user.typing.started","payload":{"sender":"81819250831"}}

        https://api.amolatina.com/presence/79541745731
        {
            "online": true,
            "devices": [
                {
                "name": "webapp"
                },
                {
                "name": "webrtc",
                "meta": {}
                },
                {
                "name": "instance",
                "meta": {
                    "id": 16202573134952774
                }
                },
                {
                "name": "fingerprint",
                "meta": {
                    "value": "vNvGLDPeIiu3QuG+9rpGIpeqrkW7LHJiYTwe+c6o3CE="
                }
                }
            ]
            }


        https://api.amolatina.com/dialogs/messages/79541745731:81819250831   -> client-operator
        {"tag":16202675843859132,"text":"hello"}
                                   

        https://api.amolatina.com/users/81819250831/events?fresh=true&types=%2Bintroductory%2Bletter
        fresh: true
types: +introductory+letter
        */
        /*
        https://api.amolatina.com/datetime
        https://api.amolatina.com/dialogs/smiles
        https://api.amolatina.com/location
        https://www.amolatina.com/cp.web:19.1.0-rc.25/l10n/dict/countries
        https://www.amolatina.com/cp.web:19.1.0-rc.25/l10n/dict/languages
        https://www.amolatina.com/cp.web:19.1.0-rc.25/l10n/dict/interests
        https://www.amolatina.com/cp.web:19.1.0-rc.25/l10n/dict/users/roles-1
        
        
        https://api.amolatina.com/users/personal/79602433731?filter=online&gender=fem&omit=0&preferences.gender=mal&select=75&sort=7
        
        
        https://api.amolatina.com/users/personal/79602433731?country=CO&filter=online&gender=fem&omit=0&preferences.gender=mal&select=75&sort=7
        country: CO
        filter: online
        gender: fem
        omit: 0
        preferences.gender: mal
        select: 75
        sort: 7
        

        https://api.amolatina.com/presence/66278012931
        */
        $response = $this->getDataUrl($url);

        return $response;
    }

    public function sendCard( $agencyId='79602433731')
    {
        $this->agencySetup(Auth::user());

        $url = 'datetime';
        $time = $this->getDataUrl($url, []);
        $time = $time['value'];

        $timestamp  = new Carbon($time);

        $timestamp  = number_format($timestamp->getPreciseTimestamp(7) ,0,'.','');
       

        $payload   = ['tag' => $timestamp, 'text' => 'hi', 'cover' => '1f6656', 'subject' => 'hi', 'attachments' => [] ];
        
   
        $clientID  = 81457193331;
        $profileID = 81833668531;

        $url       = "dialogs/letters/$clientID/$profileID";
        $url       = "/dialogs/letters/66278012931/81833668531";

        
        $response  = $this->postDataUrl($url,  $payload);

        dd($response, $timestamp, $time);
          
       /*  this.sendMessageAmolatina(url,payload ).then(resp =>{
        console.log(resp) */
     
    }

    public function comissions( $agencyId='79602433731')
    {
        set_time_limit ( 300 );
        $params = [
            'positive' => 'false',
            'from'     => '2021-01-01',
            'to'       => '2021-05-04',
            'omit'     => '0',
            'select'   => '10000',
        ];

        $url = "credits/commissions/$agencyId";
        
        $data = $this->getDataUrl($url, $params);

        return $this->storeCommision($data);
    }

    public function storeCommision($data)
    {
        $comissions = [];
        foreach ($data as $row) {

            $comission_at = new \DateTime($row['timestamp']);
           
            $comissions[] = [
                'comission_id' => $row['commission-id'],
                'agency_id'    => $row['agency-id'],
                'curator_id'   => isset($row['curator-id']) ? $row['curator-id'] : 0 ,
                'profile_id'   => isset($row['user-id']) ? $row['user-id'] : 0, 
                'user_id'      => isset($row['user-id']) ? $row['user-id'] : 0,
                'cllient_id'   => isset($row['target-id']) ? $row['target-id'] : 0, 
                'service'      => $row['service'],
                'fact'         => $row['fact'],
                'points'       => $row['points'],
                'profit'       => $row['profit'],
                'share'        => $row['share'],
                'comission_at' => $comission_at,
                'user_id_ed'   => 1,
                'created_at'   => $comission_at->format('Y-m-d H:i:s')
            ];
        }

        $comissions = collect($comissions); 

        $chunks = $comissions->chunk(500);

        foreach ($chunks as $chunk)
        {
            $insert[] = Comission::insert($chunk->toArray());
        }

        return $insert;
    }





    public function dataProfiles()
    {
        set_time_limit ( 600 );

        $url = 'users/hierarchy/79602433731/descendants?filter.suspended=false&omit=0&select=50';
       
        $profiles    =  $this->getDataUrl($url)['users']; 
     
        $dataProfile = [];

        foreach ($profiles as $profile) {
            $userId =  $profile['user-id'];
            $dataProfile[] = $this->dataProfile($userId);
        }

        return $dataProfile;
    }

    public function getPhotoProfile($profiles)
    {
        $dataProfile = $this->dataProfile($userId);
        $photoName   = $dataProfile['thumbnail'];
        $file        = $this->getPhoto($photoName);
        $this->storePhoto($file, $photoName, 'photo_profile');
    }


    public function getPhoto($photo)
    {
       $photo    = "$photo.80x80.thumb-fd";
       $url      = "users/81845317731/photos/$photo";
       return    $this->getContentUrl($url);
    }


    public function storePhoto($file, $photoName, $storage)
    {
        return Storage::disk($storage)->put( $photoName, $file);
    }

    public function dataProfile($profileId)
    {
        $url   = "users/$profileId";
        return $this->getDataUrl($url);
    }

    public function getDataUrl($url, $params = [])
    {
        $token = $this->getToken();
        
        $header = [ 'authorization' => 'Token token="'.$token.'"' ];

        $response = Http::withHeaders($header)->get($this->BASE_URL . $url, $params);

        if($response->successful())
        {
           return $response->json();
        } 
        
        throw ValidationException::withMessages(['error' => $response  ]);

    }

    public function postDataUrl($url, $params = [])
    {
        $token = $this->getToken();
        
        $header = [ 'authorization' => 'Token token="'.$token.'"' ];

        

        $response = Http::withHeaders($header)->post($this->BASE_URL . $url, $params);

        if($response->successful())
        {
           return [$response, $params];
        } 
        return $response;
        //throw ValidationException::withMessages(['error' => $response  ]);

    }

    public function getContentUrl($url)
    {
        $token = $this->getToken();
        
        $header = [ 'authorization' => 'Token token="'.$token.'"' ];

        return Http::withHeaders($header)->get($this->BASE_URL . $url)->throw(function ($response, $e) {
            return [ 'status' => $response->status(), 'error' => $e->getMessage() ];
        })->body();
    }

    public function getToken($tokeName=false)
    {
        
        return 'c5071506-6416-48a4-8c21-9dcdb1867932';

        $tokeName = ($tokeName)  ? $tokeName :  $this->tokenName();
        
        $token = Cache::get($tokeName, false);
        
        if(!$token)
        {
            $auth = $this->getCredentials();
            
            $response = Http::withBasicAuth($auth->user, $auth->password)->get($auth->url);
            if($response->ok())
            {
                $token = $response->header('X-Token');
                Cache::put($tokeName, $token, now()->addDays(30));
                $this->agency->token        = $token;
                $this->agency->token_at     = now();
                $this->agency->token_active = now()->addDays(30);
                $this->agency->save();
                
            } else {
                throw ValidationException::withMessages([
                                                        'error'  => 'unautenticate',
                                                        'status' => $response->status(), 
                                                        'utl'    => $auth->url, 
                                                        'user'   => $auth->user,  
                                                        'agency' => $this->agency->name 
                                                        ]);
            }
        }

        return $token;
    }

    private function getCredentials()
    {
        $url = Config::select( 'value' )
                    ->where( 'name', 'url_authentitation' )
                    ->active( true )->first();

        $auth           = new \stdClass();

        $auth->user     = $this->agency->user;

        $auth->password = $this->agency->password;

        $auth->url      = $this->BASE_URL . $url->value ;

        return $auth;
    }

 

    
        
/*
    use Illuminate\Http\Client\Pool;
    use Illuminate\Support\Facades\Http;

    use Illuminate\Http\Client\Pool;
    use Illuminate\Support\Facades\Http;

    $responses = Http::pool(fn (Pool $pool) => [
    $pool->as('first')->get('http://localhost/first'),
    $pool->as('second')->get('http://localhost/second'),
    $pool->as('third')->get('http://localhost/third'),
]);

return $responses['first']->ok();
 */


   

}
