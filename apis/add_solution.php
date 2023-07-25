<?php

include('connection.php');

$response = array();
$json_data = file_get_contents("php://input");
$data = json_decode($json_data,true);




if($_SERVER["REQUEST_METHOD"] == "POST"){
    $file = $_FILES['file'];

    $file_name = $_FILES['file']['name'];
    $file_temp = $_FILES['file']['tmp_name'];

    $current_time = date('H:i:s');
    $current_date = date('Y-m-d');
    $assignment_id = $_POST['assignment_id'];
    $user_id = $_POST['user_id'];

    $target_directory = $_SERVER['DOCUMENT_ROOT'] . "\googleclone\Google-Classroom-Clone-BE\solutions\\" ;
    move_uploaded_file($file_temp, $target_directory . $file_name);

    $check_assignment = $mysqli->prepare('select * from assignments where id=?');
    $check_assignment->bind_param('i', $assignment_id);
    $check_assignment->execute();
    $check_assignment->store_result();
    $assignment_exists = $check_assignment->num_rows();

    

    if ($assignment_exists > 0){
        $query = $mysqli->prepare('insert into solutions(time, date, uploeded_file, $file_name, assignment_id, user_id) values(?,?,?,?,?)');
        $query->bind_param('sssii', $current_time, $current_date, $target_directory, $assignment_id, $user_id);
        $query->execute();
    
        $response['status'] = "success";
        $response['message'] = "Added successfully";
    } else {
        $response['status'] = "failed";
        $response['message'] = "Error";
    }
}
else{
    exit("POST request method required");
}

if(empty($_FILES)){
    exit("File is empty");
}

echo json_encode($response);
?>