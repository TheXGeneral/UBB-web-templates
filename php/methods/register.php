<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
include_once './utils/env.php';
include_once './utils/db.php';

// add the new user to the database
$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $_POST['email']);
$stmt->bindParam(':password', $_POST['password']);

// is insert successful?
if($stmt->execute()){
    // get userid 
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $user = $result[key($result)];
    // compute the token and return it
    $encryption = openssl_encrypt($user['id'], $ciphering,
              $encryption_key, $options, $encryption_iv);
    echo json_encode(['success' => true, 'token' => $encryption]);
}
else{
    echo json_encode(['success' => false, 'message' => 'User already exists']);
}

?>