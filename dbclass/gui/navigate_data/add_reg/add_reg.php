<?php
include '../../../class.php';
//enumera campos para esta hoja
$cont_cpo=0;
$det=$_GET["det"]; 
//$det[0] dbname / $det[1] tname / $det[2] field id / $det[3] field name
$det=explode($sep_int,$det);
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
<form name="tablen" action="proc_reg.php" method="post">
<input type="hidden" name="hid_fid" value="<?php echo $det[2]; ?>">
<div id="div_p_addntabla" style="position:absolute; width:111px; height:34px; z-index:1; left: 4px; top: 8px;">
<!-- inicio DIVS registros *debo cargar ruta desde php dbname->tname->field name y mostrarlo aca -->
<div id="divtkey_1" style="position:absolute; width:706px; height:27px; z-index:1; left: 5px; top: 6px; background-color:#CCCCCC;">
<center>
Agregar registros para: <?php echo "</font>-></b><font color='blue' size='-1'>Nombre BD:</font><font color='green' size='-1'><b>[".$det[0]."]</font> -></b> <font color='blue' size='-1'>Tabla:</font><font color='green' size='-1'><b>[".$det[1]."]</font> -></b> <font color='blue' size='-1'>Campo:</font><font color='green' size='-1'><b>[".$det[3]."]</b></font>"; ?>
</center>
</div>

<!-- reg 1 !-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:640px; height:21px; z-index:1; left: 9px; top: 42px; background-color:#BBBFFF; "> 
	Valor:<input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');">
  </div>
	
<!-- reg 2 !-->
	<div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 70px; background-color:#BBBFFF; "> 
	Valor:<input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
	<!-- reg 3 !-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 98px; background-color:#BBBFFF; "> 
	Valor:<input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
	<!-- reg 4 !-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 126px; background-color:#BBBFFF; "> 
	Valor:<input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
	<!-- reg 5 !-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 156px; background-color:#BBBFFF; "> 
	Valor:<input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
	<!-- reg 6 !-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 184px; background-color:#BBBFFF; "> 
	Valor:<input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
	<!-- reg 7 !-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 212px; background-color:#BBBFFF; "> 
	Valor:<input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
	<!-- reg 8 !-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 240px; background-color:#BBBFFF; "> 
	Valor:<input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
	<!-- reg 9 !-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 268px; background-color:#BBBFFF; "> 
	Valor:<input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
	<!-- reg 10 !-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:610px; height:21px; z-index:1; left: 9px; top: 296px; background-color:#BBBFFF; "> 
	Valor:
	  <input type="text" name="txt_reg_<?php echo $cont_cpo; ?>" style="width:100px;" value="... <?php echo $cont_cpo; ?>">
	&nbsp; entero: (string unchecked / integer checked) <input type="checkbox" name="chk_int_<?php echo $cont_cpo; ?>">
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
<!-- boton para agregar datos -->
<div id="divbut_addtable" style="position:absolute; width:305px; height:27px; z-index:2; left: 240px; top: 339px;">
<input type="submit" value="Ingresar datos a <?php echo $det[3]; ?>!"><p></p><a href="javascript:window.close()">Cerrar Ventana</a></div>
</div>
</form>
</body>