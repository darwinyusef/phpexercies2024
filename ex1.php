<?php
// 3202051241 
// echo es para hacer imprimir pero solo texto
echo 'Hola mundito <br/>'; 
// print es para imprimir pero solo texto 
print('Hola Mundo <br/>');
// es para validar el codigo se puede meter cualquier cosa que funcione
var_dump('Hola planetita');

// esto es un objeto los objetos se construyen a partir de una key ( llave ), value ( valor ) esta tiene 4 llaves valor 
$vobject = (object) [
    "key" => "value", 
    "nombre" => "Yusef",
    "edad" => "30",
    "apellido" => "gonzalez"
];

// este es un array que arranco asì [1, 2, 3] pero yo le meti más datos
$voperator = [1, "string", ['a', 2, $vobject], True];

// asi entramos a un array bidimensional 
$l = $voperator[2][2]; 
// un array puede contener cualquier elemento 
// asi imprimimos cada valor del obj de manera individual
var_dump( $l->key , $l->nombre, $l->edad, $l->apellido );


// este es un array de dos objetos
$ArrayDosObj = [ 
    (object) [
        "title" => "leche", 
        "descript" => "la leche es algo blanco que bota la vaca"
    ], 
    (object) [
        "title" => "pan", 
        "descript" => "el pan es un producto que se hace con harina"
    ]
]; 

var_dump($ArrayDosObj);

// para obtener todas las keys de un objeto
$obkeys = array_keys((array)$vobject);
for ($i = 0; $i < 4; $i++)  {
    echo $obkeys[$i]. "  -  "; 
}

