<?php
header("refresh:12 sh_table.php");
include '../../class.php';
//revisamos variable temporal en memoria
//si no existe, la creamos y mostramos el msje de que no hay tablas ingresadas
if(!isset($_SESSION["c_data_temp"])){
echo "No hay tablas ingresadas. Ingresa una nueva para crear una base de datos!";
}

//de lo contrario si existen en sistema, se muestra listado de tablas actuales
else{
table_sh($_SESSION["c_data_temp"]);
}
?>