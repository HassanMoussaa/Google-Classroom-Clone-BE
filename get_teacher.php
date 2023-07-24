<?php
    include('connection.php');

    $class_id = $_GET['id'];

    $query = $mysqli->prepare('SELECT classrooms.id, users.email, users.first_name, users.last_name
    FROM classrooms 
    JOIN users ON classrooms.user_id = users.id
    WHERE classrooms.id=? AND users.user_type_id = 2');
    $query->bind_param('i', $class_id);
    $query->execute();
    $array = $query->get_result();
    $response = [];
    while($information = $array->fetch_assoc()){
        $response[] = $information;
    }

   echo json_encode($response);
    
   //    API: GET_TEACHER:
   //    http://localhost/Google-Classroom-Clone-BE/get_teacher.php?id=1  
?>