<?php

function validate_between($check, $min, $max)
{
    $n = mb_strlen($check);

    return $min <= $n && $n <= $max;
}

function redirectTo($url)
{
	header("Location: $url");
}

function is_logged_in()
{
    return isset($_SESSION['username']);
}
