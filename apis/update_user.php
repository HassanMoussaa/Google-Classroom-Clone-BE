<?php

include('connection.php');

$response = array();
$json_data = file_get_contents("php://input");
$data = json_decode($json_data,true);

$id = $data['id'];
$email = $data['email'];
$password = $data['password'];
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$phone_number = $data['phone_number'];
$image_path = $data['image_path'];

$check_username = $mysqli->prepare('select id from users where phone_number=?');
$check_username->bind_param('s', $phone_number);
$check_username->execute();
$check_username->store_result();
$username_exists = $check_username->num_rows();


if ($username_exists == 0) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = $mysqli->prepare('UPDATE users set password = ?, first_name=?, last_name=?, phone_number=?, image_path=? WHERE id=?');
    $query->bind_param('sssssi', $hashed_password, $first_name, $last_name, $phone_number, $image_path, $id);
    $query->execute();

    $response['status'] = "success";
    $response['message'] = "Updated successfully";
} else {
    $response['status'] = "failed";
    $response['message'] = "check the phone number is already exist";
}

echo json_encode($response);

//    API UPDATE_USER:
//    http://localhost/Google-Classroom-Clone-BE/update_user.php 
?>