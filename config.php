<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'Ibnu';

$conn = mysqli_connect($host, $user, $pass);

// Membuat database
$sql = "CREATE DATABASE IF NOT EXISTS Ibnu";
if (mysqli_query($conn, $sql)) {
    echo "";
} else {
    echo "Error membuat database: " . mysqli_error($conn);
}

mysqli_select_db($conn, $db);

// Membuat tabel
$sql = "CREATE TABLE IF NOT EXISTS Abimanyu (
    id_pembeli INT(10) PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(30) NOT NULL,
    alamat VARCHAR(50) NOT NULL,
    no_telp VARCHAR(20) NOT NULL,
    Tgl_Transaksi DATE NOT NULL,
    Jenis_barang VARCHAR(25) NOT NULL,
    Nama_barang VARCHAR(50) NOT NULL,
    Jumlah INT(20) NOT NULL,
    Harga INT(25) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "";
} else {
    echo "Error membuat table: " . mysqli_error($conn);
}

?>