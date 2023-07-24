<?php
    include('connection.php');

    $class_id = $_GET['id'];

    $query = $mysqli->prepare('SELECT classrooms.name, classrooms.section, classrooms.subject, classrooms.room, users.first_name, users.last_name
    FROM classrooms 
    JOIN users ON classrooms.user_id = users.id
    WHERE classrooms.id=?');
    $query->bind_param('i', $class_id);
    $query->execute();
    $array = $query->get_result();
    $response = [];
    while($information = $array->fetch_assoc()){
        $response[] = $information;
    }

   echo json_encode($response);

//    API: GET_CLASS
//    http://localhost/Google-Classroom-Clone-BE/get_class.php?id=1
?>