<?php
    include('connection.php');

    $user_id = $_GET['id'];

    $query = $mysqli->prepare('SELECT cl.id cl.name, cl.section, cl.subject, cl.room, u.first_name, u.last_name
    FROM enrollments en
    JOIN classrooms cl ON en.classroom_id = cl.id
    JOIN users u ON en.user_id = u.id
    WHERE en.user_id=?');

    $query->bind_param('i', $user_id);
    $query->execute();
    $array = $query->get_result();
    $response = [];
    while($information = $array->fetch_assoc()){
        $response[] = $information;
    }

   echo json_encode($response);

//    API: GET_ASSIGNMENTS
//    http://localhost/googleclone/Google-Classroom-Clone-BE/apis/get_student_classes.php?id=3
?>