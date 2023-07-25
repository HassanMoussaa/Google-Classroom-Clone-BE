<?php
    include('connection.php');

    $user_id = $_GET['id'];

    $query = $mysqli->prepare('SELECT id, name, section, subject, room, user_id
    FROM classrooms 
    WHERE user_id=?');
    $query->bind_param('i', $user_id);
    $query->execute();
    $array = $query->get_result();
    $response = [];
    while($information = $array->fetch_assoc()){
        $response[] = $information;
    }

   echo json_encode($response);

//    API: GET_ASSIGNMENTS
//    http://localhost/Google-Classroom-Clone-BE/get_teacher_classes.php?id=
?>