<?php

include('connection.php');

$response = array();
$json_data = file_get_contents("php://input");
$data = json_decode($json_data,true);

$email = $_POST['email'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone_number = $_POST['phone_number'];
$image_path = $_POST['image_path'];
$user_type = $_POST['user_type'];

$check_username = $mysqli->prepare('select email from users where email=?');
$check_username->bind_param('s', $email);
$check_username->execute();
$check_username->store_result();
$username_exists = $check_username->num_rows();

$check_phone = $mysqli->prepare('select phone_number from users where phone_number=?');
$check_phone->bind_param('s', $phone_number);
$check_phone->execute();
$check_phone->store_result();
$phone_exists = $check_phone->num_rows();

if ($username_exists == 0 && $phone_exists == 0) {
    if($user_type == "student"){
        $user_type_id = 2;
    }
    else{
        $user_type_id = 1;
    }
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = $mysqli->prepare('insert into users(email, password, first_name, last_name, phone_number, image_path, user_type_id) values(?,?,?,?,?,?,?)');
    $query->bind_param('ssssssi', $email, $hashed_password, $first_name, $last_name, $phone_number, $image_path, $user_type_id);
    $query->execute();

    $response['status'] = "success";
    $response['message'] = "Added successfully";

    if($user_type_id == 2){
        $response['user_type'] = "student"; 
    }
    else{
        $response['user_type'] = "teacher"; 
    }
} else {
    $response['status'] = "failed";
    $response['message'] = "Email or phone number already exist";
}

echo json_encode($response);

//    API:SIGNUP:
//    http://localhost/Google-Classroom-Clone-BE/signup.php  
?>