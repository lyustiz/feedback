<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


class DataController extends Controller
{
    public function index()
    {
        //$url = 'https://api.amolatina.com/credits/commissions/79602433731?from=2021-04-28T00%3A00%3A00.000Z&omit=0&positive=true&select=100&to=2021-04-28T23%3A17%3A07.050Z';
        //  users
          $url = 'https://api.amolatina.com/users/hierarchy/79602433731/descendants?filter.suspended=false&filter.tags=%2Bp&omit=0&select=100';
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
        */
        $response = $this->getDataUrl($url);

        return $response;
    }

    public function dataProfiles()
    {
        set_time_limit ( 600 );
        $url = 'https://api.amolatina.com/users/hierarchy/79602433731/descendants?filter.suspended=false&filter.tags=%2Bp&omit=0&select=50';
       
        $profiles    =  $this->getDataUrl($url)['users']; 
     
        $dataProfile = [];

        foreach ($profiles as $profile) {
            $userId =  $profile['user-id'];
            $dataProfile[] = $this->dataProfile($userId);
        }

        return $dataProfile;

    }

    public function dataProfile($profileId)
    {
        $url   = "https://api.amolatina.com/users/$profileId";
        return $this->getDataUrl($url);
    }


    public function getDataUrl($url)
    {
        $token = $this->getToken();
        
        $header = [ 'authorization' => 'Token token="'.$token.'"' ];

        return Http::withHeaders($header)->get($url)->throw(function ($response, $e) {
            return [ 'status' => $response->status(), 'error' => $e->getMessage() ];
        })->json();
    }

    public function getToken()
    {
        $token = Cache::get('token', false);

        if(!$token)
        {
            $auth = $this->getCredentials();
            
            $response = Http::withBasicAuth($auth->user, $auth->password)->get($auth->url);
            
            if($response->ok())
            {
                $token = $response->header('X-Token');
                Cache::put('token', $token, now()->addDays(30));
            }
        }

        return $token;
    }

    private function getCredentials()
    {
        $loginData = Config::select( 'value' )
                            ->group( 'login' )
                            ->activo( true )
                            ->orderBy('id')
                            ->get();

        $auth           = new \stdClass();

        $auth->user     = $loginData[0]->value;

        $auth->password = $loginData[1]->value;

        $auth->url      = $loginData[2]->value;

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
