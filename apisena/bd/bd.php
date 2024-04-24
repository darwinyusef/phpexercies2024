<?php
$hostname='localhost';
$database='apisena';
$username='root';
$password='';

$conexion=new mysqli($hostname,$username,$password,$database);
if($conexion->connect_errno){
    echo "problemas de conexion";
}
?>