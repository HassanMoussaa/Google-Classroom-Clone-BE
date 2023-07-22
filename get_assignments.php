<?php
    include('connection.php');

    $class_id = $_GET['id'];

    $query = $mysqli->prepare('SELECT title, description, due_date ,due_time
    FROM assignments 
    WHERE classroom_id=?');
    $query->bind_param('i', $class_id);
    $query->execute();
    $array = $query->get_result();
    $response = [];
    while($information = $array->fetch_assoc()){
        $response[] = $information;
    }

   echo json_encode($response);

//    API: GET_ENROLLMENT_STUDENT
//    http://localhost/Google-Classroom-Clone-BE/get_enrollment.php?id=1
?>