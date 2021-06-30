<?php

namespace App\Http\Controllers\Traits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;


trait AmolatinaDataTrait
{
  
    static public function getDataUrl($token, $url, $params = [], $headers = [], $handler = true)
    {
        $header   =  array_merge([ 'authorization' => 'Token token="'.$token.'"'], $headers); 

        $url      = config('amolatina.url') . $url;
        
        if($params)
        {
            $response = Http::withHeaders($header)->get($url, $params);
        } else {
            $response = Http::withHeaders($header)->get($url);
        }

        if($response->successful())
        {
           return [  'status' => $response->status(), 'body' =>  $response->json() , 'detail' => $response->handlerStats(), 'ok' => $response->ok() ];
        } 

        return self::errorHandler($response, $url, $params, $handler);
    }

    static public function getContentUrl($token, $url, $replaceUrl = false, $handler = true)
    {
        $header = [ 'authorization' => 'Token token="'.$token.'"' ];

        $url      =  ($replaceUrl) ? $replaceUrl . $url :  config('amolatina.url') . $url;

        $response = Http::withHeaders($header)->get($url);

        if($response->successful())
        {
            return [  'status' => $response->status(), 'body' =>  $response->body() , 'detail' => $response->handlerStats(), 'ok' => $response->ok() ];
        } 

        return self::errorHandler($response, $url, [], $handler);
    }

    static public function errorHandler($response, $url, $params, $handler = true)
    {
        $status = $response->status();

        switch ($status) {
            case 401:
                if($handler)
                {
                    throw ValidationException::withMessages(['error' => 'Token Amolatina no Valido'  ]);
                } 
                return ['error' => 'Token Amolatina no Valido', 'status' => $response->status(), 'url' => $url, 'params' => $params, 'details' => $response->handlerStats(), 'ok' => false  ];
                
                break;

            case 403:
                if($handler)
                {
                    throw ValidationException::withMessages(['error' => 'Token Amolatina no Valido'  ]);
                }
                return ['error' => 'Token Amolatina no Valido', 'status' => $response->status(), 'url' => $url, 'params' => $params, 'details' => $response->handlerStats(), 'ok' => false  ];
                break;

            case 410:
                if($handler)
                {
                    throw ValidationException::withMessages(['error' => 'Informacion no disponible', 'status' => $response->status(), 'url' => $url, 'params' => $params, 'details' => $response->handlerStats()   ]);
                }
                
                return ['error' => 'Informacion no disponible', 'status' => $response->status(), 'url' => $url, 'params' => $params, 'details' => $response->handlerStats(), 'ok' => false  ];
                break;

            default:
                if($handler)
                {
                    throw ValidationException::withMessages(['error' => [ 'status' => $response->status(), 'url' => $url, 'params' => $params, 'details' => $response->handlerStats() ]  ]);
                }
                return ['error' => 'Error en la peticion', 'status' => $response->status(), 'url' => $url, 'params' => $params, 'details' => $response->handlerStats(), 'ok' => false  ]; 
                break;
        }
    }

    static public function getSetup($type)
    {
        //TODO STORE DATABASE and Cache
        $setup  = new \stdClass();
        $setup->setParams = function(Array $params) { return array_merge($setup->params, $params);  };

        switch ($type) {

            case 'credits-profile':
                $setup->url      = 'credits/commissions';
                $setup->urlParam = ['amolatinaid'];
                $setup->header   = [ 'accept' => 'application/json+vnd.sdv.numeric' ];
                $setup->params   = ['from' => null, 'to' => null , 'grouping[0]' => 'userId', 'grouping[1]' => 'positive', 'positive'=>'null'  ];
                $setup->comments = 'total de credito/perdida de perfil segun periodo' ;
                return $setup;
                break;   

            case 'credits-curatos':
                
                $setup->url      = 'credits/commissions';
                $setup->urlParam = ['amolatinaid'];
                $setup->params   = ['from' => null, 'to' => null];
                $setup->comments = 'total de credito/perdida curator segun periodo' ;
                return $setup;
                break;
            
            case 'total-credits':
                
                $setup->url      = 'credits/commissions';
                $setup->urlParam = ['amolatinaid'];
                $setup->header   = [ 'accept' => 'application/json+vnd.sdv.numeric' ];
                $setup->params   = ['from' => null, 'to' => null];
                $setup->comments = 'total de credito/perdida agencia segun periodo' ;
                return $setup;
                break;

            case 'total-agency':
            
                $setup->url      = 'credits/commissions/stats';
                $setup->urlParam = ['amolatinaid'];
                $setup->params   = ['agency-id' => null, 'date' => '2021-06', 'from' => '2021-06-01', 'to' => '2021-06-30'];
                $setup->comments = 'total de credito/perdida agencia mes' ;
                return $setup;
                break;

            case 'total-agency-current':

                $setup->url      = 'agency/totals';
                $setup->urlParam = ['amolatinaid'];
                $setup->params   = ['type' => 'month', 'token' => null, 'from' => '2021-05-01', 'to' => '2021-05-31'];
                $setup->comments = 'total de credito/perdida agencia mes' ;
                return $setup;
                break; 

            case 'credits-detail':
                
                $setup->url      = 'credits/commissions';
                $setup->urlParam = ['amolatinaid'];
                $setup->params   = ['from' => null, 'to' => null, 'positive'=> 'null', 'omit' => '0', 'select' => '100000' ];
                $setup->comments = 'detalle de creditos/writeoff de la agencia segun periodo' ;
                return $setup;
                break;

            case 'agency-profiles':
            
                $setup->url      = 'users/hierarchy';
                $setup->urlParam = ['amolatinaid', 'descendants' ];
                $setup->params   = [ 'omit' => '0', 'select' => '100', 'filter.suspended'=> 'false', 'filter.tags' =>'+p' ];
                $setup->comments = 'lista los profiles de una agencia' ;
                return $setup;
                break;

            case 'detail-profile':
        
                $setup->url      = 'users';
                $setup->urlParam = ['amolatinaid'];
                $setup->comments = 'optiene informacion detallada de un perfil' ;
                return $setup;
                break;

            default:
                throw ValidationException::withMessages(['error' => "tipo url requerida invalido ($type)"  ]);
                break;
        }
    }

    static public function formatDateTime($dateString)
    {
        $date  = new Carbon();
        return  $date->parse($dateString)->toIso8601ZuluString('millisecond');
    }

    static public function dateRange($type, $day = null, $time = false)
    {
        $range      = new \stdClass();
        $date       = new Carbon();

        switch ($type) {

            case 'day':
                if($day!=null)
                {
                    $range->from = $date->parse($day)->toDateString();
                    $range->to   = $date->now()->toDateString();
                    return $range;
                }
                $range->from = (!$time) ? $date->now()->toDateString() : $date->now()->startOfDay()->toISOString();  
                $range->to   = (!$time) ? $date->now()->addDay()->toDateString() : $date->now()->endOfDay()->toISOString();
                return $range;
                break;

            case 'week':
                $range->from = $date->now()->firstWeekDay()->toDateString();
                $range->to   = $date->now()->lastWeekDay()->toDateString();  
                return $range;
                break;

            case 'month':
                if($day!=null)
                {
                    $range->from = $date->parse($day)->startOfMonth()->toDateString();
                    $range->to   = $date->parse($day)->endOfMonth()->toDateString();
                    return $range;
                }
                $range->from = $date->now()->startOfMonth()->toDateString();
                $range->to   = $date->now()->endOfMonth()->toDateString();
                return $range;
                break;

            case 'year':
                if($day!=null)
                {
                    $range->from = $date->parse($day)->startOfYear()->toDateString();
                    $range->to   = $date->parse($day)->endOfYear()->toDateString();
                    return $range;
                }
                $range->from = $date->now()->startOfYear()->toDateString();
                $range->to   = $date->now()->endOfYear()->toDateString();
                return $range;
                break;
            
            default:
                throw ValidationException::withMessages(['error' => "rango invalido ($type)"  ]);
                break;
        }

    }
}