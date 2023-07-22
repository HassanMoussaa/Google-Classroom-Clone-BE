<?php

include('connection.php');

$response = array();
$json_data = file_get_contents("php://input");
$data = json_decode($json_data,true);

$name = $data['name'];
$section = $data['section'];
$subject = $data['subject'];
$room = $data['room'];
$user_id = $data['user_id'];

$check_user = $mysqli->prepare('select * from users where id=?');
$check_user->bind_param('i', $user_id);
$check_user->execute();
$check_user->store_result();
$user_exists = $check_user->num_rows();

if ($name != "" && $user_exists > 0){
    $query = $mysqli->prepare('insert into classrooms(name, section, subject, room, user_id) values(?,?,?,?,?)');
    $query->bind_param('ssssi', $name, $section, $subject, $room, $user_id);
    $query->execute();

    $response['status'] = "success";
    $response['message'] = "Added successfully";
} else {
    $response['status'] = "failed";
    $response['message'] = "Missing information";
}

echo json_encode($response);

//    API:ADD_CLASS:
//    http://localhost/Google-Classroom-Clone-BE/add_class.php  
?>