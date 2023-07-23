<?php
include('connection.php');
// $_POST = json_decode(file_get_contents('php://input'), true);


  $code = $_POST['code'];

   $query = $mysqli->prepare('select user_id from password_reset where code = ? AND expiration_date >= NOW()');
    $query->bind_param('s', $code);
    $query->execute();
    $user_id = $query -> get_result();

    if ($query->num_rows() > 0) {
    $response['status'] = 'success';
    $response['message'] = 'code is valid and not expired.';
    $response['user_id']=$user_id

} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid or expired code.';
}

echo json_encode($response);
