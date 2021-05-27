<?php
namespace App\ScheduleObjects;
use App\Models\Comission;
use Carbon\Carbon;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;

class ComissionDetail
{
    use Amolatina;
    
    public function __invoke()
    {
        set_time_limit ( 900 );

        $currents = Comission::with(['agency:id,amolatina_id,name,token'])
                             ->groupBy('agency_id', 'positive')
                             ->get(['agency_id','positive', \DB::raw('MAX(comission_at) as comission_at')]); 

        $stored = []; 

        foreach ($currents  as $current) {

            $token        = $current->agency->token;
            $amolatina_id = $current->agency->amolatina_id;
            $start_at     = Carbon::parse($current->comission_at)->toDateTimeLocalString('millisecond');
            $end_at       = Carbon::now('UTC')->toDateTimeLocalString('millisecond');
            $response     = $this->getDetailCommisions($token, $amolatina_id, $start_at, $end_at, $current->positive );

            if($response['ok']) {
                $commisions = $response['body'];
                $stored[$start_at.'-'.$end_at] = count($this->storeCommision($commisions, $current->positive)) * 500;
            } else {
                $stored[$start_at . '-' . $end_at . '-' . $current->positive] = $response;
            }
        }
    }

    public function getDetailCommisions($token, $amolatinaId, $startAt, $endAt, $positive = 1)
    {
        $setup          = Amolatina::getSetup('credits-detail');
        $url            = $setup->url . '/' . $amolatinaId;
        $params         = $setup->params;
        $params['from'] = Amolatina::formatDateTime($startAt);
        $params['to']   = Amolatina::formatDateTime($endAt);
        $params['select']   = 100000;
        $params['positive'] =  ($positive == 1) ? 'true' : 'false';

        return   Amolatina::getDataUrl( $token, $url, $params);
    }

    public function storeCommision($commisions, $positive = null)
    {
        $data = [];
        foreach ($commisions as $row) {

            $comission_at = new \DateTime($row['timestamp']);
           
            $data[] = [
                'comission_id' => $row['commission-id'],
                'agency_id'    => $row['agency-id'],
                'positive'     => $positive,
                'curator_id'   => isset($row['curator-id']) ? $row['curator-id'] : 0 ,
                'profile_id'   => isset($row['user-id'])    ? $row['user-id'] : 0, 
                'user_id'      => isset($row['user-id'])    ? $row['user-id'] : 0,
                'client_id'    => isset($row['target-id'])  ? $row['target-id'] : 0, 
                'service'      => $row['service'],
                'fact'         => $row['fact'],
                'points'       => $row['points'],
                'profit'       => $row['profit'],
                'share'        => $row['share'],
                'comission_at' => $comission_at,
                'user_id_ed'   => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ];
        }

        $data = collect($data); 

        $chunks = $data->chunk(500);

        $insert = [];

        foreach ($chunks as $chunk)
        {
            $insert[] = Comission::insert($chunk->toArray());
        }

        return $insert;
    }
}
