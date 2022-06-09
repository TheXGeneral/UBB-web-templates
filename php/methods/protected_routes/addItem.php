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
// perform the add
$sql = "INSERT INTO files (name, genre, format, path) VALUES (:name, :genre, :format, :path)";
$stmt = $pdo->prepare($sql);

// get the data from the post request and bind it to the sql statement
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':genre', $_POST['genre']);
$stmt->bindParam(':format', $_POST['format']);
$stmt->bindParam(':path', $_POST['path']);

// actual execution
if($stmt->execute()){
    echo json_encode(['success' => true]);
}
else{
    echo json_encode(['success' => false, 'message' => 'error']);
}
?>