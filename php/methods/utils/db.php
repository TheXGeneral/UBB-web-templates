<?php
// DO NOT TOUCH THIS
include_once "env.php";
$opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false);
$pdo = new PDO($db_link, $db_user, $db_pass, $opt);

?>