<?php
include('connection.php');


if (isset($_POST['email'])) {
// $_POST = json_decode(file_get_contents('php://input'), true);

$email = $_POST['email'];
$query = $mysqli->prepare('select id from users where email = ?');
$query->bind_param('s', $email);
$query->execute();
$query->store_result();


if ($query->num_rows() > 0) {

   $code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);

   $expiration_date = date('Y-m-d H:i:s', strtotime('+1 hour'));


   $insert_query = $mysqli->prepare('insert into password_reset (user_id, code, expiration_date) VALUES (?, ?, ?)');
   $insert_query->bind_param('iss', $user_id, $code, $expiration_date);
   $insert_query->execute();

        // for email sending    
        $to = $email;
        $subject = 'Password Reset Token';
        $message = 'Your password reset token is: ' . $code;
        $headers = 'From: noreply@yourdomain.com' . "\r\n" .
           'Reply-To: noreply@yourdomain.com' . "\r\n" ;
           



    if (mail($to, $subject, $message, $headers)) {
        // email sent successfully
        $response['status'] = 'success';
        $response['message'] = 'Password reset token sent to your email.';
    } else {
        // email sending failed
        $response['status'] = 'error';
        $response['message'] = 'Failed to send password reset token. Please try again .';
 }
}else {
    $response['status'] = "error";
    $response['message'] = "no such email";
}

 echo json_encode($response);

 } else {
    // smail not provided in the request (this is used to deal with errors )
    $response['status'] = 'error';
    $response['message'] = 'Email not provided in the request.';
    echo json_encode($response);
}