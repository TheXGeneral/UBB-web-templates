<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
include_once '../utils/db.php';
include_once '../utils/auth.php';

// check if user is authorized
if(!check_user(getallheaders()['Authorization'])){
  echo json_encode(['success' => false, 'message' => 'unauthorized']);
  exit;
}

// get id from header ajax request
$id = getallheaders()['id'];

//execute the delete
$stmt = $pdo->prepare('DELETE FROM files WHERE id = :id');
if($stmt->execute([ 'id' => $id ])){
    echo json_encode(['success' => true]);
}
else{
    echo json_encode(['success' => false, 'message' => 'error']);
}
?>
