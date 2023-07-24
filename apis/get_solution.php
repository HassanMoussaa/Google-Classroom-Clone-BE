<?php
    include('connection.php');

    $assignment_id = $_GET['assignment_id'];
    $user_id = $_GET['user_id'];

    $query = $mysqli->prepare('SELECT  solutions.time, solutions.date, solutions.uploeded_file, solutions.file_name, users.first_name, users.last_name
    FROM solutions 
    JOIN users ON solutions.user_id = users.id
    WHERE user_id = ? AND assignment_id = ?' );
    $query->bind_param('ii', $user_id, $assignment_id);
    $query->execute();
    $array = $query->get_result();
    $response = [];

    

    while($information = $array->fetch_assoc()){
        $response[] = $information;
    }

    echo "dffdaas";
    echo json_encode($response);

//    API: GET_SOLUTION
//    http://localhost/Google-Classroom-Clone-BE/get_solutions.php?id=
?>