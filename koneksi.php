<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kasir2"; 

$conn = mysqli_connect("localhost", "root", "", "db_kasir2");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
