<?php

$mail->Host = 'localhost'; 
$mail->SMTPAuth = true; 
$mail->isSMTP(); 
$mail->SMTPDebug = 4; 
$mail->Port = 25; 
$mail->SMTPSecure = 'ssl'; 
$mail->isHtml(true); 
$mail->setFrom('info@example.com', $name); 
$mail->addReplyTo($replyto, 'noreply@example.com'); 
$mail->addAddress("example@test.com"); 
$mail->Subject = $subject; 
$mail->msgHtml($html); 
$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test 