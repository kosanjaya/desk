<?php
 $servername = "192.168.1.5";
 $username = "windows";
 $password = "windows";
 $database = "Data_Mahasiswa";

 $conn = new mysqli($servername, $username, $password, $database);

 $sql = "SELECT * FROM peserta_kuliah WHERE NIM = 412687";


$enkripFile = file_get_contents('enkrip_kunci.pem');
$key = file_get_contents('key/private_key.pem');

openssl_private_decrypt($enkripFile, $decryptedAESkey, $key);
openssl_decrypt($sql, 'AES-128-CBC', $decryptedAESkey, )
echo $decryptedAESkey;



?>