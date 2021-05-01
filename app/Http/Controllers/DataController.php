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
        
        $response = $this->getDataUrl($url);

        return $response;
    }

    public function dataProfiles()
    {
        $url = 'https://api.amolatina.com/users/hierarchy/79602433731/descendants?filter.suspended=false&filter.tags=%2Bp&omit=0&select=50';
       
       /*  $profiles    =  $this->getDataUrl($url)['users']; */
        $profiles = ["81845317731","81844657031","81844510331","81844280731","81832271631","81734119331","81550121431","81549954531","81541406531","81527386731"];
         $profiles = ["81527557431","81448319831","81447572131","80309295631","80838501431","81197226731","80726737331","80114266731","81042199831","81005418931"];
        $profiles = ["81042647431","81016012231","80913239131","80894256231","80116520431","80430501631","80708684631","80732570431","80725437431"];
        $profiles = ["80708093931","80704639831","80681441931","80400401731","80344861531","80311032931","80313661531","80705017431","80699856631","80314532931"];
        $profiles = ["80312622531","80178950831","80112244731","79863139131","79826006531","79734315931"]; /**/
        $dataProfile = [];

        foreach ($profiles as $profile) {
            //$userId =  $profile['user-id'];
            $url    = "https://api.amolatina.com/users/$profile?include=goods";
            $dataProfile[] = $this->getDataUrl($url);
        }

        return $dataProfile;

    }

    public function dataProfile($profileId)
    {
        $url   = "https://api.amolatina.com/users/$profileId?include=goods";
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
