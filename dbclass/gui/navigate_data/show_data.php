<?php
//libs
include '../../class.php';
//gui que contiene n registros para un field id unico, cargamos contenido de memoria
if(isset($_GET['det'])){
//sh_data[0] data encrypted / sh_data[1] arguments($various)
sh_data($_SESSION['data_main'],$_GET['det']);
}

//si queremos agregar un nuevo registro (para memoria temporal, de estructura de contenido de BD) [$_SESSION['data_storage']]

//si queremos modificar un registro existente (para memoria temporal, de estructura de contenido de BD) [$_SESSION['data_storage']]

//si queremos eliminar un registro (para memoria temporal, de estructura de contenido de BD) [$_SESSION['data_storage']]
?>