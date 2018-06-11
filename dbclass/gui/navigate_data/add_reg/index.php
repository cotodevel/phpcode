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
include '../../../class.php';
//version db_show para agregar datos a field id
function db_show_add($dataarg){
global $separador;global $sep_int;$data=decrypt_db($dataarg);$check_fid=0;$check_table=0;
//formato en memoria $data es ds_dbid:null00-00null00-00tkey:null00-00null00-00dbfid:null00-00null00-00pk0ai0-+//+-rs_fid:null00-00fval:pk1ai000-00Bereta-+//+-rs_fid:null00-00fval:pk1ai100-00string_data[auto_incr]-+//+-
//para $data creamos nuevo array donde solo definimos la estructura de la BD, filtrando solo por ds_dbid:...
$data=(explode($separador,$data));$cnt_data=count($data);
for($i=0;$i<$cnt_data-1;$i++){
//si $data[$i] es ds_dbid:...
switch($data[$i]):
case(strstr($data[$i],"ds_dbid")):$temp[]=explode($sep_int,$data[$i]);break;
case(strstr($data[$i],"rs_fid")):$rs[]=explode($sep_int,$data[$i]);break;endswitch;
}
//si no hay datos en memoria, error
if (!isset($temp)) { echo 'data invalida en memoria, re-ingrese la BD'; exit(); }

//enumera cantidad de registros contenidos en campo
$cnt_reg=0;
//solo si hay registros los enumera
if(isset($rs)) $nrsfid=count($rs);
else $nrsfid=0;
//gui
echo "<center>";$nreg=count($temp);for($i=0;$i<$nreg;$i++){$db[$temp[$i][0]]=$temp[$i][1];}for($i=0;$i<$nreg;$i++){$tk[]=$temp[$i][2].$sep_int.$temp[$i][3].$sep_int.$temp[$i][0];}
for($i=0;$i<$nreg;$i++){$fd[]=$temp[$i][4].$sep_int.$temp[$i][2];}$data=null;$tdata=arr_unique($tk);$tk_uniq=arr_unique($tk);$cnt_tk=count($tk_uniq);$cnt_fd=count($fd);
//gui db, no me sirve crear ciclos para mas datos aca, porque enumera cantidad de BD, y no cantidad de registros en total
echo "<table border='4'>";
foreach($db as $dbid=>$dbname){
	//imprime DB
	echo "<td><center><font color='green' size='+2'>Base de Datos:[<b>".$dbname."</b>]</font><p></p>";				
		//contar tablas unicas, crear un ciclo y compararlas contra cant de tablas
		for($i=0;$i<$cnt_tk;$i++){
			//tab 0 tkey , tab 1 tname, tab 2 dbid
			$tab=explode($sep_int,$tk_uniq[$i]);
				//segundo ciclo, comprueba 1 para n valores de la tabla, asociados a su tkey y current DBID
				for($j=0;$j<$nreg;$j++){
					//[0] tkey / [1] tname / [2] dbid
					$tab_j=explode($sep_int,$tk[$j]);
					if ($dbid==$tab_j[2] && $dbid==$tab[2] && $tab_j[0]==$tab[0])
					{
					echo "<font color='red' size='+1'>Tabla:[<b>".$tab_j[1]."</b>]</font><p></p>";
						//mientras estamos aca, abrimos otro ciclo, para asociar los field ids
							for($f=0;$f<$nreg;$f++){
								//fid actual $fdata[0] / tkey asociado $fdata[1]
								$fdata=explode($sep_int,$fd[$f]);
								$fid_f=substr($fdata[0],6);
									//ciclo para obtener total de registros
									for($jp=0;$jp<$nrsfid;$jp++){
										//cada field id de ciclo rs que coincida con ciclo $f externo..
										$fid_int=substr($rs[$jp][0],7);
											switch($fid_int):case($fid_f):$cnt_reg=$cnt_reg+1;endswitch;
									}
								//si field ids coinciden 
								switch($fdata[1]):
									case($tab[0]):
										if(!$cnt_reg) $cnt_reg=0;
										echo "<a href=javascript:popUp('./add_reg.php?det=".$temp[$f][1].$sep_int.$temp[$f][3].$sep_int.$temp[$f][4].$sep_int.$temp[$f][5]."')><font color='blue' size='-1'>Campo: [<b>".$temp[$f][5]."</b>] - Registro(s): [".$cnt_reg."]</font></a><p></p>";
									break;
								endswitch;
									//fin si field ids coinciden
							//al terminar el ciclo de n campos, limpiamos variable $cnt_reg (tot de registros)
							$cnt_reg=null;
							//fin ciclo field id
							}
					//si encontramos una tabla, matamos el ciclo n tablas de inmediato
					$j=$nreg;
					//fin si tabla actual de ciclo $i coincide con ciclo tablas de $j
					}
				//fin ciclo n tablas de $j
				}
		//fin ciclo tablas unicas de $i
		}
echo "</td></table><table border='3'>";
//fin gui DB
}
echo "</center>";
//fin funcion
}
//gui
echo "<center><font size='+1'><b>*Haga click en el campo que desea ingresar datos*</b><p></p><a href='javascript:window.close()'>Cerrar Ventana</a></font><p></p>";
//muestro db show, pero interactivo. Hago click en el campo que quiero ingresar data
db_show_add($_SESSION['data_main']);
echo "</center>";
?>