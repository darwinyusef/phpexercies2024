<?php
$hostname = 'localhost';
$database = 'apisena';
$username = 'root';
$password = '';

try {
    $conexion = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?>