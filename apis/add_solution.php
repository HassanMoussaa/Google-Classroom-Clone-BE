<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $file = $_FILES['file'];

    $file_name = $_FILES['file']['name'];
    $file_temp = $_FILES['file']['tmp_name'];

    echo $file_name . $file_temp;


    $target_directory = 'C:/xamp/htdocs/Google-Classroom-Clone-BE/solutions/';
    move_uploaded_file($file_temp, $target_directory . $file_name);
}
else{
    exit("POST request method required");
}

if(empty($_FILES)){
    exit("File is empty");
}


?>