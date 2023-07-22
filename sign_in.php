<?php
include('connection.php');
$_POST = json_decode(file_get_contents('php://input'), true);

$email = $_POST['email'];
$password = $_POST['password'];
$phone_number=$_POST['phone_number']

$mysqli  = $mysqli->prepare('select id,email,password,first_name,last_name,user_type_id,image_path,phone_number from users where email=? OR phone_number=?');
$mysqli ->bind_param('ss', $email,$phone_number);
$query->execute();

$query->store_result();
$query->bind_result($id,$email,$hashed_password,$first_name,$last_name,$user_type_id,$image_path,$phone_number);
$query->fetch();

$num_rows = $query->num_rows();
if ($num_rows == 0) {
    $response['status'] = "Email/Phone number not found";
    } else {
    if (password_verify($password, $hashed_password)) {
        $response['status'] = 'logged in';
        $response['first_name'] = $first_name;
        $response['last_name'] = $last_name;
        $response['user_type_id'] = $user_type_id;
        $response['image_path'] =$image_path

    } else {
        $response['status'] = "Email/Phone number and/or password is incorrect";
    }
}


echo json_encode($response);
