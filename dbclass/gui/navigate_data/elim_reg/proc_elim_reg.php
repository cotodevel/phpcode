<?php 
if(isset($_GET['data'])){
//libs
include '../../../class.php';
//data a eliminar desde reg_fid
$regdata=$_GET['data'];
//field id original de donde remover data
$fid=$_GET['id'];

//enum regs // decrypt data
$data=(decrypt_db($_SESSION['data_main']));$data=(explode($separador,$data));$cnt_data=count($data);
$strdata=null;
echo "<center>";
for($i=0;$i<$cnt_data-1;$i++){
//si $data[$i] es rs_dbid: la procesamos...
switch($data[$i]):
case(strstr($data[$i],"rs_fid")):
//temp[0] field id ori, [1] data held, [2] field values 
$temp=explode($sep_int,$data[$i]);
//de field id actual, data contenido a eliminar---
	switch($temp[1]):
				//coincide con data a eliminar...
				case($regdata):
				//se elimina
				
				//volcado de $data
				for($i=0;$i<count($data)-1;$i++){
				//consultamos id y data contenida que nos importa
				$var=explode($sep_int,$data[$i]);
				//$var[0] ds_dbid:id... / rs_fid:id... / $var[1] data (solo si es rs_fid)
					//si fid y data es encontrada, se ignora
					if($var[0]=="rs_fid:".$fid && $var[1]==$regdata){
					//var_dump($fid,$reg);
					}
					// de lo contrario, se mantiene (para cualquier dato diferente, sea o no registro rs_fid o db_dbfid)
					else{
					$strdata.=$data[$i].$separador;
					}

				}
	//fin busca data contenida a eliminar
	break;endswitch;
//fin consule solo rs_fid
break;endswitch;
//fin ciclo
}
//re-encriptamos
$enc=null;
$enc=encrypt($strdata);
$enc=$enc['encoded'].$separador.$enc['w_del'].$separador.$enc['password'];
$_SESSION['data_main']=$enc;
$enc=null;$strdata=null;
echo "<center>El dato <font color='red'>".$regdata."</font> ha sido eliminado exit&oacute;samente!"; 
echo "<p></p><a href='javascript:window.close();'>Cerrar Ventana</a></center>";
//fin si recibe id y data
}
?>