<?php
    include('connection.php');

    $class_id = $_GET['id'];
    // $user_id = $_GET['user_id'];

    
    
    $query = $mysqli->prepare('SELECT asi.id, asi.title as Post, u.first_name, u.last_name, asi.time as Published
    FROM assignments asi
    JOIN classrooms c ON asi.classroom_id = c.id
    JOIN users u ON c.user_id = u.id
    WHERE asi.classroom_id = ?
    UNION
    SELECT an.id, announcement as Post, u.first_name, u.last_name, an.time as Published
    FROM announcements an
    JOIN users u ON an.user_id = u.id
    WHERE classroom_id = ?
    ORDER BY Published DESC');
    $query->bind_param('ii', $class_id, $class_id);
    $query->execute();
    $array = $query->get_result();
    $response = [];
    while($information = $array->fetch_assoc()){
        $response[] = $information;
    }

   echo json_encode($response);

//    API: GET_THREAD
//    http://localhost/Google-Classroom-Clone-BE/get_thread.php?id=
?>