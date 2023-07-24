<?php
include('connection.php');
// $_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_GET['id'];


$query = $mysqli->prepare('SELECT classrooms.id, classrooms.name, classrooms.section, classrooms.subject, classrooms.room
FROM classrooms
INNER JOIN enrollments ON classrooms.id = enrollments.classroom_id
WHERE enrollments.user_id = ?');


$query->bind_param('i', $user_id);
$query->execute();


$query->store_result();
$query->bind_result($class_id, $class_name, $class_section, $class_subject, $class_room);

$classes = array();
while ($query->fetch()) {
    
    $response['id'] = $class_id;
    $response['name'] = $class_name;
    $response['section'] = $class_section;
    $response['subject'] =$class_subject;
    $response['room'] =$class_room;

    $classes[] = $response;
};



if (empty($classes)) {
    $response['status'] = "No classes found for the given user";
} else {
    $response['status'] = "success";
    $response['classes'] = $classes;
}


echo json_encode($response);
