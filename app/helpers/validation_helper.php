<?php

function validate_between($check, $min, $max)
{
    $n = mb_strlen($check);

    return $min <= $n && $n <= $max;
}

function  encrypt_decrypt($action, $string)
{
	$key = 'Ven muerte tan escondida';

	$iv = md5(md5($key));

	if ($action == 'encrypt') {
		$output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
		$output = base64_encode($output);
	}

	else if ($action == 'decrypt') {
		$output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
		$output = rtrim($output, "");
	}

	else {
		$output = NULL;
	}

	return $output;
}

function is_logged_in()
{
    return isset($_SESSION['username']);
}
