<?php

namespace App\Http\Controllers\Traits;
use App\Models\Horario;
use Illuminate\Support\Facades\Validator;

trait HorarioTrait
{

    static public function getToken($tokeName, $tableName, $tableID, $col='value')
    {
        $token = Cache::get($tokeName, false);

      /*   $tableName    = Str::snake($request->resource);

        $params = \DB::table($tableName)->select($col)->where('id', $tableID); */
                    

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

}
