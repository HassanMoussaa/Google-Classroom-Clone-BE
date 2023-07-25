<?php
    include('connection.php');

    $class_id = $_GET['id'];

    $query = $mysqli->prepare('SELECT users.first_name, users.last_name, users.image_path
    FROM enrollments 
    JOIN users ON enrollments.user_id = users.id
     WHERE enrollments.classroom_id=?');
    $query->bind_param('i', $class_id);
    $query->execute();
    $array = $query->get_result();
    $response = [];
    
    $query2 = $mysqli->prepare('SELECT COUNT(id)
    FROM enrollments
    WHERE classroom_id=?');
    $query2->bind_param('i', $class_id);
    $query2->execute();
    $query2->bind_result($student_count);
    $query2->fetch();
    echo $student_count;

    $response['student_count'] = $student_count;

    while($information = $array->fetch_assoc()){
        $response['enrollments'][] = $information;
    }

   echo json_encode($response);

//    API: GET_ENROLLMENT_STUDENT
//    http://localhost/Google-Classroom-Clone-BE/get_enrollment.php?id=1
?>