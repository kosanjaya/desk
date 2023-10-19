<?php
$text = 'tugas keamanan basis data';

$pubKey = file_get_contents('key/public_key.pem');

openssl_public_encrypt($text, $encryptedAESkey, $pubKey);

file_put_contents('enkrip_kunci.pem', $encryptedAESkey);

$iv = openssl_random_pseudo_bytes(16);
$de = base64_encode($iv);
echo $de;

// $d = 'jVctVnHS+Yp5AbioxcjrI4+Jw9DqeWwe9fO2rLCOkX0=';
// $d = $de;

// $i = base64_decode($iv);
// echo $iv.'<br>';
// echo $i.'<br>';

?>