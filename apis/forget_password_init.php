<?php
include('connection.php');

$requestData = file_get_contents('php://input');
echo "Received email: " . $requestData;


$_POST = json_decode(file_get_contents('php://input'), true);

$email = $_POST['email'];
$query = $mysqli->prepare('SELECT id FROM users WHERE email = ?');
$query->bind_param('s', $email);
$query->execute();
$query->store_result();

if ($query->num_rows() > 0) {
   $query->bind_result($user_id);
    $query->fetch();
   $code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);

   $expiration_date = date('Y-m-d H:i:s', strtotime('+1 hour'));


   $insert_query = $mysqli->prepare('insert into password_resets (user_id, code, expiration_date) VALUES (?, ?, ?)');
   $insert_query->bind_param('iss', $user_id, $code, $expiration_date);
   $insert_query->execute();

        // for email sending    
        $to = $email;
        $subject = 'Password Reset Token';
        $message = 'Your password reset code is: ' . $code;
        $headers = "MIME-Version:1.0" . "\r\n" ;
        $headers .= "Cotent-type:text/html;charset=UTF-8" . "\r\n" ;
        $headers .= 'From: <classroomgrp10@gmail.com>' . "\r\n" ; 



    if (mail($to, $subject, $message, $headers)) {
        // email sent successfully
        $response['status'] = 'success';
        $response['message'] = 'Password reset code sent to your email.';
    } else {
        // email sending failed
        $response['status'] = 'error';
        $response['message'] = 'Failed to send password reset code. Please try again .';
 }
}else {
    $response['status'] = "error";
    $response['message'] = "no such email";
}

 echo json_encode($response);

