<html>
<head>
<script>
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=760,height=532');");
}
</script>
</head>
<link rel="stylesheet" type="text/css" href="libs/DWStyle.css" />
<?php
include 'class.php';
$data=null;
echo "<body id='main'>";
if (!isset($_GET['class_objin'])){
//Primera vez que se ejecuta el programa

}
//colector dinamico de acciones por HTML (main es objeto INDEX.PHP y dbshow es objeto AJAX_DBSHOW.PHP)
else {
session_start();
$data=$_SESSION['data_main'];
$value=($_GET['class_objin']);
//depuramos que enviamos en el formulario con funcion dep_data();
dep_data($value);
}

//GUI
echo "<center>";

echo "Gestion de Operaciones de base de datos";

//tabla de operaciones
echo "<table border='1'>";

//agregamos nueva BD ID completa (requiere al menos una tabla con su nombre, y un nombre para el campo, y valor de dicho campo
echo "<td>";
echo "<a href=javascript:popUp('gui/index.php?val=addnewbd')>Agregar nueva BD!</a>";
echo "<td>";

//modificamos BD ID completa (requiere al menos una tabla con su nombre, y un nombre para el campo, y valor de dicho campo
echo "<td>";
echo "<a href=javascript:popUp('gui/modif_data/index.php')>Modificar BD existente!</a>";
echo "<td>";

//Eliminamos BD ID completa existente (requiere al menos una tabla con su nombre, y un nombre para el campo, y valor de dicho campo
echo "<td>";
echo "<a href=javascript:popUp('gui/elim_data/index.php')>Eliminar BD existente!</a>";
echo "<td>";

echo "</table>";
echo "<p></p>";

//gui gestion de datos (agregar, modificar, eliminar)
echo "Gestion de Registros almacenados";
echo "<table border='1'>";
//agregar
echo "<td>";
echo "<a href=javascript:popUp('gui/navigate_data/add_reg/index.php')>Agregar un registro a la BD!</a>";
echo "<td>";

//modificar un registro
echo "<td>";
echo "<a href=javascript:popUp('gui/navigate_data/modif_reg/index.php?val=importdata')>Modificar un registro de la BD!</a>";
echo "<td>";

//eliminar un registro
echo "<td>";
echo "<a href=javascript:popUp('gui/navigate_data/elim_reg/index.php')>Eliminar un registro de la BD!</a>";
echo "<td>";


echo "</table>";
echo "<p></p>";

//operaciones de consulta sobre registros
echo "DB structure (depurador)";
echo "<table>";
echo "<td>";
echo "<a href=javascript:popUp('gui/engine/index.php')>current DB data!</a>";
echo "<td>";
echo "</table>";

echo "<p></p>";

//herramientas de mantencion
echo "<table border='1'>";

echo "Herramientas de mantenci&oacute;n";
echo "<table border='1'>";

//Importar datos completos de BD (encriptado)
echo "<td>";
echo "<a href=javascript:popUp('gui/index.php?val=importdata')>Importar BD al sistema!</a>";
echo "<td>";


//Exportar datos completos de BD (encriptado)
echo "<td>";
echo "<a href=javascript:popUp('gui/index.php?val=exportdata')>Exportar BD del sistema!</a>";
echo "<td>";

//Guardar cambios permanentemente para la BD (encriptado)
echo "<td>";
echo "<a href=javascript:popUp('gui/index.php?val=savedata')>Guardar cambios en BD permanentemente!</a>";
echo "<td>";

//Reconstruir una DB con el formato correcto
echo "<td>";
echo "<a href=javascript:popUp('gui/index.php?val=builddb')>Reconstruir y exportar una BD con el formato correcto!</a>";
echo "<td>";

//Destruir archivo fisico de DB en el servidor:
echo "<td>";
echo "<a href=javascript:popUp('gui/index.php?val=destroydata')>Destruir BD permanentemente en el servidor!</a>";
echo "<td>";

//fin tabla operaciones
echo "</table>";

echo "<p></p>";

//STATUS BD
echo "Bases de Datos actuales<p></p>";
echo "<iframe src='ajax_dbshow.php' noresize scrolling='yes' id='dbshow' style='width:690px;height:700px'></iframe><p></p>";

echo "<p></p><a href='index.php' target='dbshow'>refrescar pagina</a></center>";
echo "</body>";
?>
</html>