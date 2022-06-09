<?php

// adapt these for your needs
$db_link = "mysql:host=localhost;dbname=web;";
$db_user = "thexgeneral";
$db_pass = "Thexgeneral2022*";


// dont touch this. These are the config variables for the encryption
$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$encryption_iv = '1234567891011121';
$encryption_key = "cheie_smechera";

?>