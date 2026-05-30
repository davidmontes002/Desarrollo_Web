<?php
// conexion.php
$host = "sql100.infinityfree.com";
$user = "if0_41683681";
$password = "TU_CONTRASEÑA_AQUI"; // Sustituye por tu contraseña real
$dbname = "if0_41683681_practica_final";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>