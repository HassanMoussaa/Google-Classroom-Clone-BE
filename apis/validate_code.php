<?php
include('connection.php');
$_POST = json_decode(file_get_contents('php://input'), true);

$code = $_POST['code'];

$query = $mysqli->prepare('SELECT user_id FROM password_resets WHERE code = ?');
$query->bind_param('s', $code);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $response['status'] = 'success';
    $response['message'] = 'Code is valid and not expired.';
    $user_id_data = $result->fetch_assoc();
    $response['user_id'] = $user_id_data['user_id'];
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid or expired code.';
}

echo json_encode($response);
?>
