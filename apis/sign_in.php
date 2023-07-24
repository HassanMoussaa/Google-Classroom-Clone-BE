<?php
include('connection.php');
// $_POST = json_decode(file_get_contents('php://input'), true);

$input = $_POST['input'];
$password = $_POST['password'];


// Check if the input looks like a phone number
if (preg_match('/^[0-9]+$/', $input)) {
    // input is a phone number
    $query = $mysqli->prepare('select id, email, password, first_name, last_name, user_type_id, image_path, phone_number from users where phone_number=?');
    $query->bind_param('s', $input);
} else {
    // input is an email
    $query = $mysqli->prepare('select id, email, password, first_name, last_name, user_type_id, image_path, phone_number from users where email=?');
    $query->bind_param('s', $input);
}
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
        $response['id']=$id;
        $response['first_name'] = $first_name;
        $response['last_name'] = $last_name;
        $response['user_type_id'] = $user_type_id;
        $response['image_path'] =$image_path;

    } else {
        $response['status'] = "Email/Phone number and/or password is incorrect";
    }
}


echo json_encode($response);
