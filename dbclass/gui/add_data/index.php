<?php
include '../../class.php';

//para verificar que BD en memoria funciona
decrypt_db($_SESSION['data_main']);

//conteador de table ids
$ctid=0;
//contador de field ids
$cfid=0;
//flag que pregunta si eliminamos o conservamos datos en memoria de tablas
if(!isset($_GET['elim_tablas'])) $elimtabla=0;
else $elimtabla=1;

//flag de pregunta continua carga de pagina
if(!isset($_GET['ask'])) $cgoahead=0;
else $cgoahead=1;

//si existen datos de tabla en memoria preguntamos si deseamos continuar editando esos, o crear una BD nueva
if($cgoahead==0 && isset($_SESSION["c_data_temp"])){
echo "<center><b>Hay tablas en memoria que tienes pendientes. <p></p> Deseas crear una nueva BD y eliminar las tablas en memoria?";
echo "<p></p>";
echo "<a href='./index.php?ask=1'>Conservar datos de tabla antes ingresadas y continuar!</a>";
echo "<p></p>";
echo "<a href='./index.php?ask=1&elim_tablas=1'>Eliminar datos de tablas antes ingresadas y continuar!</a></b></center>";
exit();
}

//si deseamos eliminar tablas en memoria, nullizamos $_SESSION["c_data_temp"].. $elimtabla=1
if ($elimtabla==1) $_SESSION["c_data_temp"]=null;
?>

<html>
<head>
<!-- Jquery necesario -->
<script type="text/javascript" src="jquery171.js">
</script>
<script language="javascript">
<!-- popup func -->
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=760,height=532');");
}


<!-- IVA del sistema -->
var iva_sistema = 0.19;
parseFloat(iva_sistema);
<!-- Fin IVA -->

<!-- disable DIVS -->
function disabledivs(){
document.getElementById("divfid_2").disabled=true;
document.getElementById("divfid_3").disabled=true;
document.getElementById("divfid_4").disabled=true;
document.getElementById("divfid_5").disabled=true;
document.getElementById("divfid_6").disabled=true;
document.getElementById("divfid_7").disabled=true;
document.getElementById("divfid_8").disabled=true;
document.getElementById("divfid_9").disabled=true;
document.getElementById("divfid_10").disabled=true;

}
<!-- enable n div -->
function enablediv(val){
document.getElementById(val).disabled=false;
}

<!-- disable n div -->
function disablediv(val){
document.getElementById(val).disabled=true;
}
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>

</head>
<body>
<center>
<form name="DB_frm" method="POST" action="process_newdb.php">
  <div id="div_bdname" style="position:absolute; width:295px; height:54px; z-index:3; left: 16px; top: 10px;">
  <font color="#000066"><b>Ingrese el nuevo nombre para su base de datos:</b></font> 
  <p></p>
  <input type="text" name="db_name" value="nuevo nombre BD...">
  </div>
  
    
  <div id="div_addtabla" style="position:absolute; width:209px; height:28px; z-index:4; left: 73px; top: 108px;">
  <input type="button" value="Agregar nueva tabla" onClick="javascript:popUp('./add_table.php')">
  </div>
  
<!-- fin form actual !-->
<div id="div_butsubmit" style="position:absolute; width:200px; height:64px; z-index:2; left: 77px; top: 150px;">
<input type="submit" value="Ingresar BD al sistema!"><p></p><a href='javascript:window.close()'>Cerrar Ventana</a>
</div>
<!-- div muestra actual de tablas ingresadas -->
<div id="div_tablestatus" style="position:absolute; width:115px; height:58px; z-index:5; left: 318px; top: 14px;">
<!-- form refresh auto tablas en memoria a ingresar [temporales]-->
<?php echo "<iframe src='sh_table.php' noresize scrolling='yes' id='tbshow' style='width:400px;height:300px'></iframe><p></p>"; 
echo "<p></p>";
echo "<a href='./sh_table.php' target='tbshow'>Refrescar Pagina</a>"
?>
</div>
</form>
</center>
</body>
</html>