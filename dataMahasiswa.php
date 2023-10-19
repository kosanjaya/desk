<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Prodi</th>
            <th>Gender</th>
            <th>Tanggal Lahir</th>
        </tr>
        <?php
        $servername = "192.168.1.5";
        $username = "windows";
        $password = "windows";
        $database = "Data_Mahasiswa";

        $conn = new mysqli($servername, $username, $password, $database);

        function decrypt($data){
            $fileEnkripKey = file_get_contents('enkrip_kunci.pem');
            $fileKey = file_get_contents('key/private_key.pem');
            $vektor = 'EfOVoW1q13gplsznx+9kvw==';
            $iv = base64_decode($vektor);

            openssl_private_decrypt($fileEnkripKey, $key, $fileKey);

            $decrypted = openssl_decrypt($data, 'AES-256-CBC', $key, 0, $iv);
            return $decrypted;
        }

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM peserta_kuliah";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['NIM'] . "</td>";
                echo "<td>" . decrypt($row['Nama']) . "</td>";
                echo "<td>" . $row['Jurusan'] . "</td>";
                echo "<td>" . $row['Prodi'] . "</td>";
                echo "<td>" . $row['Gender'] . "</td>";
                echo "<td>" . $row['TanggalLahir'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "Tidak ada data.";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>