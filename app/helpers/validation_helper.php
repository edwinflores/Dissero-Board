<?php

function validate_between($check, $min, $max)
{
    $n = mb_strlen($check);

    return $min <= $n && $n <= $max;
}

function is_valid_format($string)
{
    return !(preg_match('/[^a-zA-Z0-9_]/', $string));
}

function  encrypt_decrypt($action, $string)
{
    $key = 'Ven muerte tan escondida';

    $iv = md5(md5($key));

    $output = NULL;

    if ($action == 'encrypt') {
        $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
        $output = rtrim($output, "\0");
    }

    return $output;
}

function is_logged_in()
{
    return isset($_SESSION['username']);
}

function is_valid_username($username)
{
    return (validate_between($username, MIN_USERNAME_CHARACTERS, MAX_USERNAME_CHARACTERS) 
                        && is_valid_format($username));
}

function is_valid_password($password)
{
    return validate_between($password, MIN_PASSWORD_CHARACTERS, MAX_PASSWORD_CHARACTERS);
}

function sendConfirmCode($confirm_code, $email)
{
    $receiver = $email;
    $subject = "Thy Confirmation Code";
    $from = "From: Con Firmer <confirmer@disseroboard.com>";

    $message="Your Confirmation link \r\n";
    $message.="Click on this link to activate your account \r\n";
    $message.="10.3.10.42/user/confirmation?passkey=$confirm_code";

    $sentmail = mail($receiver, $subject, $message, $from);

    if(!$sentmail) {
        echo "Error!";
    }
}