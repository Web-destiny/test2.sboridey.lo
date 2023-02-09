<?php

$mail_to = "babenkops.ll@gmail.com";

if($name = trim(htmlspecialchars($_POST['name']))){
$message .= 
'Имя: '.$name;}

if($tel = trim(htmlspecialchars($_POST['phone']))){
$message .=
'
Телефон: '.$tel;}

if($email = trim(htmlspecialchars($_POST['email']))){
$message .=
'
E-mail: ' .$email;}

if($form_id = trim(htmlspecialchars($_POST['form_id']))){
$message .=
'
Form: ' .$form_id;}

$message = wordwrap($message, 70, "\r\n");

if (mail($mail_to, 'Сообщение с сайта Сбор идей', $message)){
    echo json_encode('ok');
}else{
    echo json_encode('err');
}

?>