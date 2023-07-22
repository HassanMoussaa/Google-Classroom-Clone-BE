<?php
include('connection.php');
// $_POST = json_decode(file_get_contents('php://input'), true);


  $token = $_GET['token'];

   $query = $mysqli->prepare('select user_id from password_reset where token = ? AND expiration_date >= NOW()');
    $query->bind_param('s', $token);
    $query->execute();
    $query->store_result();

    if ($query->num_rows() > 0) {
    $response['status'] = 'success';
    $response['message'] = 'Token is valid and not expired.';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid or expired token.';
}

echo json_encode($response);
