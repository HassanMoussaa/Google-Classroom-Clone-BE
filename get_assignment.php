<?php
    include('connection.php');

    $assignment_id = $_GET['id'];

    $query = $mysqli->prepare('SELECT title, description, due_date ,due_time
    FROM assignments 
    WHERE id=?');
    $query->bind_param('i', $assignment_id);
    $query->execute();
    $result = $query->get_result();
    $response = [];
    while($information = $result->fetch_assoc()){
        $response[] = $information;
    }

   echo json_encode($response);

//    API: GET_ASSIGNMENT
//    http://localhost/Google-Classroom-Clone-BE/get_assignment.php?id=1
?>