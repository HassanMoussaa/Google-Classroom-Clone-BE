<?php
include('connection.php');
// $_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];


if ($new_password === $confirm_password) {
   
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

  
    $query = $mysqli->prepare('update users set password = ? where id = ?');
    $query->bind_param('si', $hashed_password, $user_id);
    $query->execute();

    $response['status'] = 'success';
    $response['message'] = 'Password reset successful.';
} else {
    $response['status'] = 'error';
    $response['message'] = 'New password and confirm password do not match.';
}

echo json_encode($response);