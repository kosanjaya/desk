<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        body{
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            
        }
        .container{
            width: 80vh;
            margin: 100px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .container2 > input{
            width: 15rem;
            height: 2rem;
            margin: 10px;
            display: block;
        }

        .btn{
            margin: 10px;
            text-align: center;
        }
    </style>

</head>
<body>
    <form class="container" method="post">
            <div class='container2'>
                
                <label for="nim">NIM: </label>
                <input  type="text" id="nim" name='nim'>
                
                <label for="nama">NAMA: </label>
                <input  type="text" id="nama" name='nama'>

                <label for="jurusan">JURUSAN: </label>
                <input  type="text" id="jurusan" name='jurusan'>

                <label for="prodi">PRODI: </label>
                <input  type="text" id="prodi" name='prodi'>

                <label for="gender">Jenis Kelamin: </label>
                <select name="gender" id="gender">
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <br>
                <label for="tgllahir">Tanggal Lahir
                    <input  type="date" id="tgllahir" name='tgllahir'>
                </label>
                <div class="btn">
                    <button type="submit" name="submit">Submit</button>
                    <button type="submit" name="check">Cek Data</button>
                </div>
            </div>
        
    </form>
</body>
</html>


<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $conn = mysqli_connect('192.168.1.5', 'windows', 'windows', 'Data_Mahasiswa');
        if (!$conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

        function encrypt($data){
            $fileEnkripKey = file_get_contents('enkrip_kunci.pem');
            $fileKey = file_get_contents('key/private_key.pem');
            // $iv = openssl_random_pseudo_bytes(32);
            $vektor = 'EfOVoW1q13gplsznx+9kvw==';
            $iv = base64_decode($vektor);

            openssl_private_decrypt($fileEnkripKey, $key, $fileKey);
            
            // $iv = openssl_random_pseudo_bytes(16);
            $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
            return $encrypted;
        }
        
        if(isset($_POST['submit'])){
            // encrypt user input
            $nim = $_POST['nim'];
            // $nim = encrypt($_POST['nim']);
            $nama = encrypt($_POST['nama']);
            $jurusan = encrypt($_POST['jurusan']);
            $prodi = encrypt($_POST['prodi']);
            $gender = encrypt($_POST['gender']);
            $tgllahir = $_POST['tgllahir'];
            // $tgllahir= encrypt($_POST['tgllahir']);
        
            // prepare and execute SQL query
            // $sql = "INSERT INTO peserta_kuliah (NIM, Nama, Jurusan, Prodi, Gender, TanggalLahir) VALUES ($nim, '$nama', '$jurusan', '$prodi', '$gender', '$tgllahir')";
            $sql = "INSERT INTO peserta_kuliah (NIM, Nama, Jurusan, Prodi, Gender, TanggalLahir) VALUES (?, ?, ?, ?, ?, ?)";
        
            $stmt = mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($stmt, "ssssss", $nim, $nama, $jurusan, $prodi, $gender, $tgllahir);
        
            if (mysqli_stmt_execute($stmt)){
                echo "Data Tersimpan!.";
            }else{
                echo "Error: ". mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
        
        elseif(isset($_POST['check'])) {
            header('Location: dataMahasiswa.php');
            exit;
        }
    }
?>


<!-- function encrypt($data){
            $fileEnkripKey = file_get_contents('enkrip_kunci.pem');
            $fileKey = file_get_contents('key/private_key.pem');
            openssl_private_decrypt($fileEnkripKey, $key, $fileKey);
            
            $iv = openssl_random_pseudo_bytes(16);
            $encrypted = openssl_encrypt($data, 'AES-128-CBC', $key, 0, $iv);
            return $encrypted;
        }

        if(isset($_POST['submit'])){
            $nim_get = $_POST['nim'];
            $nama_get = $_POST['nama'];
            $jurusan_get = $_POST['jurusan'];
            $prodi_get = $_POST['prodi'];
            $gender_get = $_POST['gender'];
            $tgllahir_get= $_POST['tgllahir'];

            $nim = encrypt($nim_get);
            $nim = encrypt($nama_get);
            $nim = encrypt($jurusan_get);
            $nim = encrypt($prodi_get);
            $nim = encrypt($gender_get);
            $nim = encrypt($tgllahir_get);

            #$sql = "INSERT INTO peserta_kuliah (NIM, Nama, Jurusan, Prodi, Gender, TanggalLahir) VALUES ($nim, '$nama', '$jurusan', '$prodi', '$gender', '$tgllahir')";
            $sql = "INSERT INTO peserta_kuliah (NIM, Nama, Jurusan, Prodi, Gender, TanggalLahir) VALUES (?,?,?,?,?,?)";

            $stmt = mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($stmt, "sssss", $nim, $nama, $jurusan, $prodi, $gender, $tgllahir);

            if (mysqli_stmt_execute($stmt)){
                echo "Data Tersimpan!.";
            }else{
                echo "Error: ". mysqli_stmt_error($stmt);
            }
            // if ($conn->query($sql) === TRUE) {
            //     echo "Data berhasil disimpan";
            // } else {
            //     echo "Error: " . $sql . "<br>" . $conn->error;
            // }
            mysqli_stmt_close($stmt);
            mysqli_close($conn); 
            // $conn->close();-->