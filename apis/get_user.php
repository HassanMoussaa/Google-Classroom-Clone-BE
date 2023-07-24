<?php
    include('connection.php');

    $id = $_GET['id'];

    $query = $mysqli->prepare('SELECT users.id, users.email, users.password, users.first_name, users.last_name, users.phone_number, users.image_path, user_type.type
    FROM users 
    JOIN user_type ON users.user_type_id = user_type.id
     WHERE users.id=?');
    $query->bind_param('i', $id);
    $query->execute();
    $array = $query->get_result();
    $response = [];
    while($information = $array->fetch_assoc()){
        $response[] = $information;
    }

   echo json_encode($response);

//    API: GET_USER
//    http://localhost/Google-Classroom-Clone-BE/get_user.php?id=
?>

