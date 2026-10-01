<?php
$host     = "localhost"; 
$user     = "root";      
$password = "root";     
$database = "campus_store";
$port     = 8889;        

$koneksi = new mysqli($host, $user, $password, $database, $port);

if ($koneksi->connect_error) {
    die("Koneksi MAMP Gagal:" . $koneksi->connect_error);
}

echo "Koneksi MAMP Berhasil! Terhubung ke database: <u>" . $database . "</u>";
$koneksi->close();
?>