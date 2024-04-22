<?php

/*
crea un reporte donde pepito gasto $10 hoy y solo puede gastar $20 mañana y has la sumatoria en un objeto final tipo json
*/

$pePaMa = (object) [
    "hoy" => 10,
    "manana" => 20,
    "sumatoria" => 0,
]; 

$suma = $pePaMa->hoy + $pePaMa->manana; 
// var_dump($suma);

$pePaMa->sumatoria = $suma; 

echo json_encode($pePaMa);