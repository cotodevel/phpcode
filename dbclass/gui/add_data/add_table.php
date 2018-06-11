<?php
//enumera tablas para esta hoja
$cont_tabla=0;
//enumera campos para esta hoja
$cont_cpo=0;
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

document.getElementById("chk_ai_fid_"+(num)).disabled=false;
document.getElementById("chk_pk_fid_"+(num)).disabled=false;
}
else{

document.getElementById("divfid_"+(num)).disabled=false;

document.getElementById("minus_"+(num-1)).disabled=true;
document.getElementById("plus_"+(num-1)).disabled=true;

document.getElementById("minus_"+(num)).disabled=false;
document.getElementById("plus_"+(num)).disabled=false;
document.getElementById("chk_ai_fid_"+(num)).disabled=false;
document.getElementById("chk_pk_fid_"+(num)).disabled=false;

}
<!-- fin function !-->
}

function disablediv(val){
num=val.replace(/\D/g,'');
if(num==10){
document.getElementById("divfid_"+(num)).disabled=true;
document.getElementById("minus_"+(num)).disabled=true;
document.getElementById("chk_ai_fid_"+(num)).disabled=true;
document.getElementById("chk_pk_fid_"+(num)).disabled=true;


document.getElementById("divfid_"+(num-1)).disabled=false;
document.getElementById("plus_"+(num-1)).disabled=false;
document.getElementById("minus_"+(num-1)).disabled=false;
document.getElementById("chk_ai_fid_"+(num-1)).disabled=false;
document.getElementById("chk_pk_fid_"+(num-1)).disabled=false;

}
else{
document.getElementById("divfid_"+(num)).disabled=true;
document.getElementById("plus_"+(num)).disabled=true;
document.getElementById("minus_"+(num)).disabled=true;
document.getElementById("chk_ai_fid_"+(num)).disabled=true;
document.getElementById("chk_pk_fid_"+(num)).disabled=true;

document.getElementById("divfid_"+(num-1)).disabled=false;
document.getElementById("plus_"+(num-1)).disabled=false;
document.getElementById("minus_"+(num-1)).disabled=false;
document.getElementById("chk_ai_fid_"+(num-1)).disabled=false;
document.getElementById("chk_pk_fid_"+(num-1)).disabled=false;
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
<!-- form table -->
<form name="tablen" action="process_table.php" method="post">
<div id="div_p_addntabla" style="position:absolute; width:111px; height:34px; z-index:1; left: 4px; top: 8px;">
<!-- inicio DIVS tabla -->
<div id="divtkey_1" style="position:absolute; width:436px; height:27px; z-index:1; left: 68px; top: 6px; background-color:#CCCCCC;">
<center>
Ingrese nombre de tabla: <input type="text" name="txt_tname<?php $cont_tabla=$cont_tabla+1; echo "_".$cont_tabla; ?>" style="width:100px;" value="tabla<?php echo "_".$cont_tabla; ?>">
</center>
</div>

<!-- field ID 1, tabla 1<!-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:640px; height:21px; z-index:1; left: 9px; top: 42px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>"> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>">
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');">
  </div>
	
<!-- field ID 2, tabla 1 -->
	<div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:753px; height:21px; z-index:1; left: 9px; top: 70px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>" disabled> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>" disabled>
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
	<!-- field ID 3, tabla 1 <!-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 98px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>" disabled> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>" disabled>
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>	</div>
	
  <!-- field ID 4, tabla 1 <!-->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 126px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>" disabled> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>" disabled>
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
  <!-- field ID 5, tabla 1 -->
    <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 156px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>" disabled> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>" disabled>
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
  <!-- field ID 6, tabla 1 -->
	<div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:754px; height:21px; z-index:1; left: 9px; top: 184px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>" disabled> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>" disabled>
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
  <!-- field ID 7, tabla 1 -->
  <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 212px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>" disabled> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>" disabled>
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:
	<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>	
	</div>
	
  <!-- field ID 8, tabla 1 -->
	<div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:755px; height:21px; z-index:1; left: 9px; top: 240px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>" disabled> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>" disabled>
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	  
  <!-- field ID 9, tabla 1 -->
 <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:757px; height:21px; z-index:1; left: 9px; top: 268px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>" disabled> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>" disabled>
	Agregar campo:<input type="button" id="plus_<?php echo $cont_cpo; ?>" 
	value="+" style="width:30px;height:20px;" onClick="Javascript:enablediv('divfid_<?php echo $cont_cpo+1; ?>');" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
  
  <!-- field ID 10, tabla 1 -->
  <div id="divfid_<?php $cont_cpo=$cont_cpo+1; echo $cont_cpo; ?>" style="position:absolute; width:751px; height:21px; z-index:1; left: 9px; top: 296px; background-color:#BBBFFF; "> 
	Nombre de Campo:<input type="text" name="txt_fname_<?php echo $cont_cpo; ?>" style="width:100px;" value="campo <?php echo $cont_cpo; ?>">
	&nbsp; auto_increment: <input type="checkbox" name="chk_ai_fid_<?php echo $cont_cpo; ?>" disabled> - &nbsp; primary_key: <input type="checkbox" name="chk_pk_fid_<?php echo $cont_cpo; ?>" disabled>
	<input type="hidden" id="plus_<?php echo $cont_cpo; ?>" value="+" style="width:30px;height:20px;" disabled>
	Eliminar campo:<input id="minus_<?php echo $cont_cpo; ?>" type="button" value="-" onClick="Javascript:disablediv('divfid_<?php echo $cont_cpo; ?>');" style="width:30px;height:20px;" disabled>
	</div>
	
<div id="divbut_addtable" style="position:absolute; width:109px; height:27px; z-index:2; left: 280px; top: 339px;">
<input type="submit" value="Ingresar tabla!"><p></p><a href="javascript:window.close()">Cerrar Ventana</a></div>
<!-- tabla 1 DB <!-->
</div>
</form>
</body>