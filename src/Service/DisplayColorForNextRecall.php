<?php

namespace App\Service;

use App\Enum\enumNextRecall;
use DateTime;

class DisplayColorForNextRecall{

    public function __construct(){}

    public function DisplayColor(DateTime $nextRecall){
        $today = new DateTime();

        $interval = $nextRecall->diff($today);

        if($interval->format('%m') == 0) {
            if($interval->format('%d') == 15 || $interval->format('%d') < 15){
                return enumNextRecall::red;
            }
            if($interval->format('%d') > 15){
                return enumNextRecall::orange;
            }
        }        

        if($interval->format('%m') == 1 && $interval->format('%d') == 0){
            return enumNextRecall::orange;
        }

        
        return enumNextRecall::green;        
    }

}