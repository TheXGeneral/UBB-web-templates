<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
include_once './utils/db.php';

// if search data is empty, return all data
if(empty(getallheaders()['search'])){
    $result = $pdo->query("SELECT * FROM files");
    echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
}
else{
    $sql = "SELECT * FROM files WHERE genre LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search', '%' . getallheaders()['search'] . '%');
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
?>
