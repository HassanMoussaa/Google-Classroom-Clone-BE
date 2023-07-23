<?php

include('connection.php');

$response = array();
$json_data = file_get_contents("php://input");
$data = json_decode($json_data,true);

$title = $_POST['title'];
$description = $_POST['description'];
$duedate = $_POST['duedate'];
$duetime = $_POST['duetime'];
$classroom_id = $_POST['classroom_id'];

$check_class = $mysqli->prepare('select * from classrooms where id=?');
$check_class->bind_param('i', $classroom_id);
$check_class->execute();
$check_class->store_result();
$classroom_exists = $check_class->num_rows();

if ($title != "" && $classroom_exists > 0){
    $query = $mysqli->prepare('insert into assignments(title, description, due_date, due_time, classroom_id) values(?,?,?,?,?)');
    $query->bind_param('ssssi', $title, $description, $duedate, $duetime, $classroom_id);
    $query->execute();

    $response['status'] = "success";
    $response['message'] = "Added successfully";
} else {
    $response['status'] = "failed";
    $response['message'] = "Missing information";
}

echo json_encode($response);

//    API:ADD_ASIIGNMENT:
//    http://localhost/Google-Classroom-Clone-BE/add_assignment.php  
?>