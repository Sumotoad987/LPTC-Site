<?php
date_default_timezone_set("Europe/Dublin"); 
function format_interval(DateInterval $interval) {
        $result = "";
        if ($interval->y) { $result .= $interval->format("%y years "); }
        else if ($interval->m) { $result .= $interval->format("%m months "); }
        else if ($interval->d) { $result .= $interval->format("%d days "); }
        else if ($interval->h) { $result .= $interval->format("%h hours "); }
        else if ($interval->i) { $result .= $interval->format("%i minutes "); }
        else if ($interval->s) { $result .= $interval->format("%s seconds "); }
    
        return $result;
}

function timeSince($date){
    $current = new DateTime(date('Y-m-d H:i:s'));
    $interval = $date->diff($current);
    return(format_interval($interval));
}

?>