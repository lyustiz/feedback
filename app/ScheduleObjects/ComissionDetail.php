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
        set_time_limit ( 300 );
        
        $currentCommisions = Comission::groupBy('agency_id')
                           ->get(['agency_id', \DB::raw('MAX(comission_at) as comission_at')]);

        foreach ($currentCommisions  as  $currentCommision) {

            $token  = '33568305-c77b-4719-a97e-331610a9b170';
            $amolatina_id = $currentCommision->agency_id;
            $start =  Carbon::parse($currentCommision->comission_at)->toDateTimeLocalString('millisecond'); // ->addSecond(1)
            $end_at = Carbon::now('UTC')->toDateTimeLocalString('millisecond');
            
            $response = $this->getDetailCommisions($token, $amolatina_id, $start, $end_at );
            
            if($response['ok'])
            {
                $commisions = $response['body'];
                $this->storeCommision($commisions);
            }
        }
    }

    public function getDetailCommisions($token, $amolatinaId, $startAt, $endAt)
    {
        $setup          = Amolatina::getSetup('credits-detail');
        $url            = $setup->url . '/' . $amolatinaId;
        $params         = $setup->params;
        $params['from'] = Amolatina::formatDateTime($startAt);
        $params['to']   = Amolatina::formatDateTime($endAt);
        $params['select']   = 500;

        return   Amolatina::getDataUrl( $token, $url, $params);
    }

    public function storeCommision($commisions)
    {
        $data = [];
        foreach ($commisions as $row) {

            $comission_at = new \DateTime($row['timestamp']);
           
            $data[] = [
                'comission_id' => $row['commission-id'],
                'agency_id'    => $row['agency-id'],
                'curator_id'   => isset($row['curator-id']) ? $row['curator-id'] : 0 ,
                'profile_id'   => isset($row['user-id']) ? $row['user-id'] : 0, 
                'user_id'      => isset($row['user-id']) ? $row['user-id'] : 0,
                'client_id'    => isset($row['target-id']) ? $row['target-id'] : 0, 
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

        foreach ($chunks as $chunk)
        {
            Comission::insert($chunk->toArray());
        }
    }
}
