<?php

include('connection.php');

$response = array();
$json_data = file_get_contents("php://input");
$data = json_decode($json_data,true);

$announcement = $_POST['announcement'];
$user_id = $_POST['user_id'];
$classroom_id = $_POST['classroom_id'];
$current_time = date('Y-m-d H:i:s');

if ($announcement != ""){
    $query1 = $mysqli->prepare('insert into announcements(announcement, time, user_id, classroom_id) values(?,?,?,?)');
    $query1->bind_param('ssii', $announcement, $current_time, $user_id, $classroom_id);
    $query1->execute();

    $response['status'] = "success";
    $response['message'] = "Added successfully";
} 
else {
    $response['status'] = "failed";
    $response['message'] = "Missing information";
}


echo json_encode($response);

//    API:ADD_ANNOUCEMENT:
//    http://localhost/Google-Classroom-Clone-BE/add_announcement.php  
?>