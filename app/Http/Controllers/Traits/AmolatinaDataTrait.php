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
  
    static public function getDataUrl($token, $url, $params = [], $headers = [])
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

        self::errorHandler($response, $url, $params);
    }

    static public function errorHandler($response, $url, $params)
    {
        $status = $response->status();

        switch ($status) {
            case 401:
                throw ValidationException::withMessages(['error' => 'Token Amolatina no Valido'  ]);
                break;

            case 403:
                throw ValidationException::withMessages(['error' => 'Token Amolatina no Valido'  ]);
                break;
            default:

            dd($response);
                 throw ValidationException::withMessages(['error' => [ 'status' => $response->status(), 'url' => $url, 'params' => $params, 'details' => $response->handlerStats() ]  ]);
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