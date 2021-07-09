<?php
namespace App\ScheduleObjects;
use App\Models\ProfileProgress;
use App\Models\Agency;
use App\Models\Profile;
use Carbon\Carbon;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;

class ProfileProgressDay
{
    use Amolatina;
    
    public function __invoke()
    {
        $agencies = Agency::select('id', 'amolatina_id')->get();  

        $this->setProfiles();

        $profiles = [];

        foreach ($agencies as $agency) {
            
            $token        = $agency->token;

            $amolatina_id = $agency->amolatina_id;

            $response = $this->getProfileCommisions($token, $amolatina_id, 'day');

            if($response['ok'])
            {
                $commissions = $response['body']['commissions'];

                $profiles[] = $this->setProfileProgress($commissions, 'day');
            }
        }

        if( count($profiles) > 1 ) {
            ProfileProgress::whereNotIn('amolatina_id',  array_keys($profiles) )->update( ['profit_day' => 0, 'writeoff_day' => 0] );
        }
    }

    public function setProfiles()
    {
        $profiles  = Profile::where('status_id', 1)->doesntHave('profileProgress')->get();
        $insert    = [];  

        foreach ($profiles as $profile) {
            $insert[] = [
                'profile_id'   => $profile->id,
                'amolatina_id' => $profile->amolatina_id, 
                'user_id'      => $profile->user_id, 
                'status_id'    => $profile->status_id
            ];
        }
        return ProfileProgress::insert($insert);
    }

    public function getProfileCommisions($token, $amolatinaId, $type)
    {
        $range          = Amolatina::dateRange($type);
        $setup          = Amolatina::getSetup('credits-profile');
        $url            = $setup->url . '/' . $amolatinaId;
        $params         = $setup->params;
        $params['from'] = $range->from;
        $params['to']   = $range->to;
        $header         = $setup->header;
        return   Amolatina::getDataUrl( $token, $url, $params, $header);
    }

    public function setProfileProgress($commissions, $type)
    {
        $profile = [];
        foreach ($commissions as $commission) {

            if(isset($commission['user-id']))
            {
                
                if($type == 'month')
                {
                    $totals = ( $commission['positive'] == 'true' ) 
                          ? ['profit_month'   => $commission['profit'], 'points_month' => $commission['points'] ] 
                          : ['writeoff_month' => $commission['points']];

                } else {
                    $totals = ( $commission['positive'] == 'true' ) 
                          ? ['profit_day'   => $commission['profit'], 'points_day' => $commission['points']] 
                          : ['writeoff_day' => $commission['points']];
                }

                ProfileProgress::where('amolatina_id',  $commission['user-id'] )->update($totals);

                $profile[$commission['user-id']] = $commission['user-id'];
            }
        }

        return $profile;
    }
}
