<?php
include('connection.php');
// $_POST = json_decode(file_get_contents('php://input'), true);


  $code = $_POST['code'];

    $query = $mysqli->prepare('select user_id from password_resets where code = ? AND expiration_date >= NOW()');
    $query->bind_param('s', $code);
    $query->execute();
    $user_id = $query -> get_result();

    if ($query->num_rows() > 0) {

    $query2 = $mysqli->prepare('select password from users where id= ?');
    $query2->bind_param('i', $user_id);
    $query2->execute();
    
    if ($query2->num_rows() > 0) {
    $password = $query2 -> get_result();
    $response['status'] = 'success';
    $response['message'] = 'code is valid and not expired.';
    $response['password']=$password;
    $response['user_id']=$user_id;
    }

} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid or expired code.';
}

echo json_encode($response);
