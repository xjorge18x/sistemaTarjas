<?php
// funcion de conectar
$servername = 'CSOFSR04\SQLEXPRESS';
$conectioninfo= array("DataBase" => "bd_SIGTAPRO", "UID"=>"sa", "PWD"=>"Coin#2022", "CharacterSet"=>"UTF-8");
$conectar = sqlsrv_connect($servername,$conectioninfo);


$conectioninfo2= array("DataBase" => "BDFloresCo", "UID"=>"sa", "PWD"=>"Coin#2022", "CharacterSet"=>"UTF-8");
$conectar2 = sqlsrv_connect($servername,$conectioninfo2);


// if ($conectar== false)
// {
// echo "Fallo la conexion";
// die(print_r(sqlsrv_errors(), true));
// }
// else{
// echo "todo ok ";
// }
