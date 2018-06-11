<?php
include '../../../class.php';
//enumera campos para esta hoja
$cont_cpo=0;
$det=$_GET["det"]; 
//$det[0] dbname / $det[1] tname / $det[2] field id / $det[3] field name
$det=explode($sep_int,$det);
//formato reg struct por defecto
$regffid="rs_fid:";
?>
<head>
<script language="javascript" type="text/javascript">
<!-- disable DIVS -->
<!-- divs -->
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
<!-- campos -->

}
<!-- enable n div -->
function enablediv(val){
num=val.replace(/\D/g,'');
if(num==2){
document.getElementById("plus_"+(num-1)).disabled=true;

document.getElementById("divfid_"+(num)).disabled=false;
document.getElementById("minus_"+(num)).disabled=false;
document.getElementById("plus_"+(num)).disabled=false;

document.getElementById("txt_reg_"+(num)).disabled=false;
document.getElementById("chk_int_"+(num)).disabled=false;
}
else if(num==10){
document.getElementById("plus_"+(num-1)).disabled=true;

document.getElementById("divfid_"+(num)).disabled=false;
document.getElementById("minus_"+(num)).disabled=false;

document.getElementById("txt_reg_"+(num)).disabled=false;
document.getElementById("chk_int_"+(num)).disabled=false;
}
else{

document.getElementById("divfid_"+(num)).disabled=false;

document.getElementById("minus_"+(num-1)).disabled=true;
document.getElementById("plus_"+(num-1)).disabled=true;

document.getElementById("minus_"+(num)).disabled=false;
document.getElementById("plus_"+(num)).disabled=false;
document.getElementById("txt_reg_"+(num)).disabled=false;
document.getElementById("chk_int_"+(num)).disabled=false;

}
<!-- fin function !-->
}

function disablediv(val){
num=val.replace(/\D/g,'');
if(num==10){
document.getElementById("divfid_"+(num)).disabled=true;
document.getElementById("minus_"+(num)).disabled=true;
document.getElementById("txt_reg_"+(num)).disabled=true;
document.getElementById("chk_int_"+(num)).disabled=true;

document.getElementById("divfid_"+(num-1)).disabled=false;
document.getElementById("plus_"+(num-1)).disabled=false;
document.getElementById("minus_"+(num-1)).disabled=false;
document.getElementById("txt_reg_"+(num-1)).disabled=false;
document.getElementById("chk_int_"+(num-1)).disabled=false;
}
else{
document.getElementById("divfid_"+(num)).disabled=true;
document.getElementById("plus_"+(num)).disabled=true;
document.getElementById("minus_"+(num)).disabled=true;
document.getElementById("txt_reg_"+(num)).disabled=true;
document.getElementById("chk_int_"+(num)).disabled=true;

document.getElementById("divfid_"+(num-1)).disabled=false;
document.getElementById("plus_"+(num-1)).disabled=false;
document.getElementById("minus_"+(num-1)).disabled=false;
document.getElementById("txt_reg_"+(num-1)).disabled=false;
document.getElementById("chk_int_"+(num-1)).disabled=false;
}
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
<body onLoad="javascript:disabledivs();">
<?php
//enum regs
$data=(decrypt_db($_SESSION['data_main']));
$data=(explode($separador,$data));
$cnt_data=count($data);
?>

<form name="tablen" action="proc_regmodif.php?cnt_data=<?php $fid=explode($sep_int,$data[0]); 
echo $cnt_data-2; ?>" method="post">
<input type="hidden" name="hid_fid" value="<?php echo $regffid; ?>">
<input type="hidden" name="hid_fid_n" value="<?php echo $det[2]; ?>">

<div id="div_p_addntabla" style="position:absolute; width:111px; height:34px; z-index:1; left: 4px; top: 8px;">
<!-- inicio DIVS registros *debo cargar ruta desde php dbname->tname->field name y mostrarlo aca -->
<div id="divtkey_1" style="position:absolute; width:706px; height:27px; z-index:1; left: 5px; top: 6px; background-color:#CCCCCC;">
<center>
<b>Modificar Registros existentes</b><p></p> <?php echo "</font>-></b><font color='blue' size='-1'>Nombre BD:</font><font color='green' size='-1'><b>[".$det[0]."]</font> -></b> <font color='blue' size='-1'>Tabla:</font><font color='green' size='-1'><b>[".$det[1]."]</font> -></b> <font color='blue' size='-1'>Campo:</font><font color='green' size='-1'><b>[".$det[3]."]</b></font>"; ?>

<!-- n reg !-->
<?php
echo "<center>";
for($i=0;$i<$cnt_data-1;$i++){
//si $data[$i] es rs_dbid: la procesamos...
switch($data[$i]):
case(strstr($data[$i],"rs_fid")):
//temp[0] rs_fid: [1] data [2] value / ($det[2])substr == reg fid
$temp=explode($sep_int,$data[$i]);
	switch(substr($temp[0],7)):
		case(substr($det[2],6)):
		$ai=(substr($temp[2],3,3));
		$int=(substr($temp[2],6,4));
		echo "<font color='red' size='-1'>Valor Actual:</font><input type='text' name='".$regffid.$cont_cpo."' value='".$temp[1]."'>";
		if($int=="int0") echo "entero: <input type='checkbox' name='chk_int".$cont_cpo."'>";else if($int=="int1") echo "entero: <input type='checkbox' name='chk_int".$cont_cpo."' checked>";if($ai=="ai1") echo "AUTO_INCREMENT: <input type='checkbox' name='chk_ai".$cont_cpo."' checked disabled>";else if($ai=="ai0") echo "AUTO_INCREMENT: <input type='checkbox' name='chk_ai".$cont_cpo."' disabled>";$cont_cpo=$cont_cpo+1;echo "<p></p>";
	break;endswitch;
break;endswitch;
}
if ($cont_cpo!=0) echo "<p></p><input type='submit' value='Guardar Cambios! (".$cont_cpo.")'><p></p><a href='javascript:window.close()'>Cerrar Ventana</a></div><p></p>";
else echo "<p></p><b>No hay registros!</b><p></p><a href='javascript:window.close()'>Cerrar Ventana</a>";
echo "</center>";
?>
</div></center>
</form>
</body>