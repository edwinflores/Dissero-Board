<?php

function time_ago($subjectTime)
{
	$etime = time() - strtotime($subjectTime);

	if ($etime < 1) {
		return '0 seconds';
	}

	$interval = array(12*30*24*60*60 => 'year',
					30*24*60*60 => 'month',
					24*60*60 => 'day',
					60*60 => 'hour',
					60 => 'minute',
					1 => 'second');

	foreach ($interval as $secs => $str) {
		$difference = $etime / $secs;

		if ($difference >= 1) {
			$result = round($difference);
			$output = $result . ' ' . $str . ($result > 1 ? 's' : '') . " ago";
			return  $output;
		}
	}
}