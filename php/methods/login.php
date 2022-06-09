<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
include_once './utils/env.php';
include_once './utils/db.php';

$sql = "SELECT * FROM users WHERE email = :email AND password = :password";
$stmt = $pdo->prepare($sql);

// get data from post request and bind it to the sql statement
$stmt->bindParam(':email', $_POST['email']);
$stmt->bindParam(':password', $_POST['password']);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$user = $result[key($result)];

if($user){
  // if there is an user, I compute the token and return it
  $encryption = openssl_encrypt($user['id'], $ciphering,
            $encryption_key, $options, $encryption_iv);
    echo json_encode(['success' => true, 'token' => $encryption]);
}
else{
    echo json_encode(['success' => false]);
}
?>