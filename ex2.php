<?php

// 1. creamos el array 
$arryOb2Pos = [1,2];
// 2. creamos el obj
$obj1 = (object) [
    "pr1" => "huevos", 
    "pr2" => "carne", 
    "fecha" => "21/04/2024"
]; 
$obj2 = (object) [
    "pr1" => "salchicha", 
    "pr2" => "leche",
    "fecha" => "19/04/2024"
]; 

$arryOb2Pos[0] = $obj1; 
$arryOb2Pos[1] = $obj2; 

echo json_encode($arryOb2Pos);