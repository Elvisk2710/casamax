<?php

    function get_next_billing_date($start_epoch, $last_epoch,$unit,$period){
        // check if start epoch is defined
        if(!$start_epoch){
            echo "start epoch is needed";
            return;
        }

        if (!$last_epoch){
            $last_epoch = $start_epoch;
        }

        //  period is not defined qw assume period to be 1
        if(!$period){
            $period =1;
        }
        $this_date = date('y-m-d');
        $start_at = strtotime(date($this_date));

        // ll nown time units
        $known_units = array(
            'daily'=> 1,
            'monthly' => 1,
            'year' => 1,
        );

        // chek if the given range is nown
        if(!array_key_exists($unit,$known_units)){
            echo 'time is not defined';
            return;
        }

        $duration = $known_units[$unit];
        $duration = $duration * $period;

        $start = new DateTime('@'.$start_epoch);
        $last = new DateTime('@'.$last_epoch);

        $year = (int)$last->format('Y');
        $month = (int)$last->format('n');
        $day= (int)$start->format('j');

        $hms = $start->format('G:i:s');

        switch($unit){
            case 'daily':
                $day += $duration;
                break;
            case 'monthly':
                $month += $duration;
                break;
            case 'year':
            $year += $duration;
            break;
                default:
                echo 'invalid time unit';
                return;
        }

        if($day > 31){
            $num_of_days = $last->format('t');
            while($day>31){
                $day = $day - $num_of_days;
                $month +=1;
            }
        }
        
        if($month > 12){
            
            $year += 1;          
            $difference = $month - 13;
            $month = 1;
            $month = $month + $difference;
        }

        while(true){
            $next = new DateTime("{$year}-{$month}-{$day} {$hms} UTC");
            if(($next->format('n')) == $month){
                break;
            }else{
                $day--;
            }
        }

        return(int)$next->format('U');
    }
?>