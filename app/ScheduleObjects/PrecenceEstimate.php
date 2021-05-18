<?php
    namespace App\ScheduleObjects;
    use App\Models\UserPresence;

    class PrecenceEstimate
    {
        public function __invoke($x)
        {
            $userPresences  =  $userPresence->where('status_id', 3)
        }
    }
?>