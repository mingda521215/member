<?php

require("vendor/autoload.php");
session_start();

$mail = new PHPMailer;

$mail->isSMTP();


$mail->SMTPDebug = 0;
$mail->Host = 'imap.gmail.com';
$mail->Port = 693;
$mail->SMTPSecure = 'SSL';
$mail->SMTPAuth = true;
$mail->Username = 'mdhost123@gmail.com', 'mdhost123';
$mail->Password = 'mingda5168';


$mail->setFrom('mdhost123@gmail.com');
$mail->addAddress('wooweb@icloud.com', 'wooweb');
$mail->Subject = 'Mail test';
$mail->msgHTML('Hi there');
$mail->AltBody = 'Hi there';

if (!$mail->send()) {
	echo $mail->ErrorInfo;
	die();
}

echo '<div class="alert alert-success">Message sent.</div>';
