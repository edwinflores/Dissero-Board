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
		$output = rtrim($output, "\0");
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

function sendConfirmCode($confirm_code, $email)
{
    $receiver = $email;
    $subject = "Thy Confirmation Code";
    $from = "From: Mark Fischbach <markiplier@freddyfazzbears.com>";

    $message="Your Confirmation link \r\n";
    $message.="Click on this link to activate your account \r\n";
    $message.="10.3.10.42/user/confirmation?passkey=$confirm_code";

    $sentmail = mail($receiver, $subject, $message, $from);

    if(!$sentmail) {
        echo "Error!";
    }
}