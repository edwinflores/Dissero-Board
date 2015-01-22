<?php

const MINUTE_SECOND = 60;
const HOUR_SECOND = 3600;
const DAY_SECOND = 86400;
const WEEK_SECOND = 604800;
const MONTH_SECOND = 2592000;
const YEAR_SECOND = 31104000;

function time_ago($subjectTime)
{
    $deltaTime = time() - strtotime($subjectTime);

    if ($deltaTime < 1) {
        return 'Just now.';
    }

    $secondConversion = array(YEAR_SECOND => 'year',
                    MONTH_SECOND => 'month',
                    WEEK_SECOND => 'week',
                    DAY_SECOND => 'day',
                    HOUR_SECOND => 'hour',
                    MINUTE_SECOND => 'minute',
                    1 => 'second');

    foreach ($secondConversion as $secs => $str) {
        $difference = $deltaTime / $secs;

        if ($difference >= 1) {
            $result = round($difference);
            $output = $result . ' ' . $str . ($result > 1 ? 's' : '') . " ago";
            return $output; 
        }
    }
}