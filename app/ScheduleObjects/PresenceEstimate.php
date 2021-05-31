<?php
namespace App\ScheduleObjects;
use App\Models\UserPresence;
use Carbon\Carbon;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;

class PresenceEstimate
{
    use Amolatina;
    
    public function __invoke()
    {
        set_time_limit ( 300 );
        $searches = UserPresence::select('user_presence.start_at', 'agency.amolatina_id', 'agency.token')
                                    ->join('profile', 'profile.id', '=', 'user_presence.profile_id')
                                    ->join('agency', 'agency.id', '=', 'profile.agency_id')
                                    ->where('user_presence.status_id', 3)
                                    ->distinct()
                                    ->get();

        $userPresences = UserPresence::with(['profile:profile.id,amolatina_id', 'profile.agency:agency.id,amolatina_id'])
                                    ->where( 'status_id' , 3)
                                    ->get();

        $end_at = Carbon::now('UTC')->toDateTimeLocalString('millisecond');
        
        foreach ($searches as $search) {
            
            $response = $this->getProfileCommisions($search->token, $search->amolatina_id, $search->start_at, $end_at);

            if($response['ok'])
            {
                $commissions = $response['body']['commissions'];

                $this->setPrecenseCommisions($userPresences, $commissions, $search->start_at);
            }
        }
    }

    public function getProfileCommisions($token, $amolatinaId, $startAt, $endAt)
    {
        $setup          = Amolatina::getSetup('credits-profile');
        $url            = $setup->url . '/' . $amolatinaId;
        $params         = $setup->params;
        $params['from'] = Amolatina::formatDateTime($startAt);
        $params['to']   = Amolatina::formatDateTime($endAt);
        $header         = $setup->header;

        return   Amolatina::getDataUrl( $token, $url, $params, $header);
    }

    public function setPrecenseCommisions($userPresences, $commissions,  $startAt)
    {
        foreach ($userPresences as $userPresence) {

            $amolatina_id  = $userPresence->profile->amolatina_id; 
    
            $totals  =  [ 
                'bonus'    => 0,
                'writeoff' => 0,
                'shared'   => 0,
                'profit'   => 0,
            ];
    
            foreach ($commissions as $commission) {
                
                if( $commission['user-id'] == $amolatina_id &&  $startAt == $userPresence->start_at )
                {
                    $totals[ 'bonus' ]    =  $totals[ 'bonus' ]    + (($commission['positive']) ? $commission['points'] : 0) ; 
                    $totals[ 'writeoff' ] =  $totals[ 'writeoff' ] + ((!$commission['positive']) ? $commission['points'] : 0) ; 
                    $totals[ 'shared' ]   =  $totals[ 'shared' ]   + $commission['share'];
                    $totals[ 'profit' ]   =  $totals[ 'profit' ]   + $commission['profit'];
                    $totals[ 'comments' ] =  'automate';
                }
            }
            if(isset($totals[ 'comments' ]))
            {
                UserPresence::find($userPresence->id )->update($totals);
            }
    
            
        }
    }
}
