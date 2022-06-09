<?php
include_once 'env.php';
include_once 'db.php';
//encription is autorization  header
function check_user($token){
  // make variables usable in the function context
  global $ciphering , $encryption_key, $encryption_iv, $options;
  global $pdo;

  // remove the Bearer from the token
  $encryption = substr($token, 7);
  // decrypt the token
  $decryption=openssl_decrypt ($encryption,$ciphering, 
        $encryption_key, $options, $encryption_iv);
  $id = (int)$decryption;
  
  // I guarantee that ids are strictly bigger than 0, so I can return false if the $id smaller than 0
  if($id <= 0){
    return false;
  }
  // check if the user exists
  $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
  $stmt->execute([ 'id' => $id ]);
  $user = $stmt->fetch();
  if($user){
    return true;
  }
  else{
    return false;
  }
}
?>