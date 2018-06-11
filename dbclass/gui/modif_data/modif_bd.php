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
</html>
<?php
//dbid a modificar
$dbid=$_GET["det"];
include '../../class.php';

//retorna data sstructura
function get_dbdata($dataarg){
global $separador;global $sep_int;$data=decrypt_db($dataarg);$check_fid=0;$check_table=0;
$data=(explode($separador,$data));$cnt_data=count($data);
for($i=0;$i<$cnt_data-1;$i++){
switch($data[$i]):case(strstr($data[$i],"ds_dbid")):$holder[]=explode($sep_int,$data[$i]);break;
//case(strstr($data[$i],"rs_fid")):$rs[]=explode($sep_int,$data[$i]);break;
endswitch;
}
return $holder;
}

//get various db data
$holder=get_dbdata($_SESSION['data_main']); 
//summarize accurate db data ($holder(new_uniquedata)<-$holder(old_alldata) )
//holder index 0 dbid holder 1 dbname
$cnt_data=count($holder);
for($j=0;$j<$cnt_data;$j++){
switch($holder[$j][0]):case($dbid):$holder=$holder[$j];$j=$cnt_data;break;endswitch;}

//se envia a sh_table.php (holder(new))
$_SESSION['cur_db']=$holder;

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
<form name="DB_frm" method="POST" action="update.php">
  <div id="div_bdname" style="position:absolute; width:295px; height:48px; z-index:3; left: 37px; top: 6px;">
  <font color="#000066"><b>Nombre actual BD:</b></font> 
  <p></p>
  <input type="text" name="db_name" value="<?php echo $holder[1] ?>">
  </div>
<!-- fin form actual !-->
<div id="div_butsubmit" style="position:absolute; width:200px; height:64px; z-index:2; left: 364px; top: 26px;">
<input type="button" value="Agregar nueva tabla" onClick="javascript:popUp('./add_table.php')"><p></p>
<input type="submit" value="guardar cambios de BD!"><p></p><a href='javascript:window.close()'>Cerrar Ventana</a>
</div>

</form>
<div id="Layer1" style="position:absolute; width:387px; height:3145px; z-index:6; left: -8px; top: 73px;">
<?php
//gui muestro db show, pero interactivo. Hago click en el campo que quiero modificar (tabla y campo)
echo "<b>Modifique Tabla</b>";
dbsh_modif_table($_SESSION['data_main']);
?>
</div>
</center>
</body>
</html>