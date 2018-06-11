<?php
include 'enc/encdec20.php';
include 'libs/ftp_modif.php';
session_start();
//revisa si hay ftp o no
if(($cid)||($resultado)==false) $_SESSION['ftp_disabled']=0;
else $_SESSION['ftp_disabled']=1;
//nuestro flag que indica si BD fue cargada de FTP o no
//nuestro flag que dice si registro actual duplicado para BD ID YA FUE ABIERTO O NO
//nuestro flag que dice si registro actual duplicado para TABLE ID YA FUE ABIERTO O NO
//separador de archivos dentro de array(s)
$check_dbloadftp=null;
$check_bdid=0;
$check_tname=0;
$separador="-+//+-";
//separador interno
$sep_int="00-00";
//$fdefdata campo con parametros [primary key0/1 - auto increment0/1] en DB fvalue
$fdefdata="pk0ai0";
//variable $data
(int)$data=NULL;

function uniq(){$uid=substr(microtime().rand(1,1000),3,7);$uid.=substr($uid,1,2);return $uid;}
function db_data($file){
global $check_dbloadftp,$dir_remota,$filedr,$db_nm;
if ($check_dbloadftp==0){$_SESSION['data_main']=$file;
$check_dbloadftp=1;
}
else if (isset($_FILES["uploadedfile"])) {
$_SESSION['data_main']=file_get_contents($_FILES["uploadedfile"]["tmp_name"]);
$_FILES["uploadedfile"]=null;
return $_SESSION['data_main'];
}
else {
return $_SESSION['data_main'];
}
}

function decrypt_db($file){
global $separador;global $sep_int;global $fdefdata;$ds=null;$rs=null;
//db_data revisa si hay datos encriptados en memoria, carga desde ftp db.txt o recibe variable $file actual, volcandolo en variable $_SESSION['data_main'];
db_data($file);
if($_SESSION["data_main"]==1) {echo "<center><b>No hay una BD cargada en memoria. Genera una y c&aacute;rgala al sistema.</b></center>"; exit(); }
//decrypt pide :($encrypted['encoded'],$encrypted['password'],$encrypted['w_del'])
//0= encrypted 1= w_del 2=password
$output=explode($separador,$_SESSION['data_main']);
//desencriptado..
$dec=decrypt($output[0],$output[2],$output[1]);
//si desencripcion es correcta..
if($dec["pw_status"]=="OK"){
$dec=explode($separador,$dec['decrypted']);$cnt_dec=count($dec);
//por cada linea, necesitamos separarla de sus 00s (cada linea equivale a un registro), -1 linea en blanco
for($i=0;$i<$cnt_dec-1;$i++){
//array->0 => string 'null00null00null00null00null00null00null' (length=40)
$dump=explode($sep_int,$dec[$i]);
//validacion de desencripcion correcta, pero armado de data incorrecta error (cambio de formato en estructura de archivos)
if(!count($dump)>6)
{echo "<center>Error, la desencripci&oacute;n fue correcta, pero al construir la data en memoria tiene incompatibilidades.";
echo "<p></p>Reconstruye la estructura para <b>".$dump[0]."</b>. (requiere crear una nueva BD y encriptarla)<p></p>";
echo "usando la estructura siguiente: <b>ds_dbid:null".$sep_int."null".$sep_int."tkey:null".$sep_int."null".$sep_int."dbfid:null".$sep_int."null".$sep_int.$fdefdata.$separador."<p></p>";
echo "</center>";
exit();
}
switch(strstr($dump[0],"ds_dbid")):case(true):$ds.=$dump[0].$sep_int.$dump[1].$sep_int.$dump[2].$sep_int.$dump[3].$sep_int.$dump[4].$sep_int.$dump[5].$sep_int.$dump[6].$separador;break;endswitch;
//register struct fid [n] estructuras rs_fid:null00-00fval:pk1ai100-00string_data[auto_incr]00-00n-+//+-
switch("rs_fid:"==substr($dump[0],0,7)):case(true):$reg=(explode($sep_int,$dec[$i]));switch(!isset($reg[3])):case(true):$rs.=$dump[0].$sep_int.$dump[1].$sep_int.$dump[2].$separador;break;case(false):$rs.=$dump[0].$sep_int.$dump[1].$sep_int.$dump[2].$sep_int.$dump[3].$separador;break;endswitch;break;endswitch;
//cierra ciclo que depura data
}
$var=($ds.$rs);unset($reg,$dump,$dec,$output);
return $ds.$rs;
//fin si depuracion es correcta
}
else{
echo "<center>error, la base de datos no fu&eacute; cargada en memoria porque es invalida. <p></p> [decrypt_bd(); returned false status]</font></td></table></center>";
exit();
}
//cierra db_decrypt
}
//recibe variables de hasta 2 niveles de array y los reordena en array simple
function temp2data($data){
//en $new_data simplificamos las lineas a procesar
$nreg=count($data);for($i=0;$i<$nreg;$i++){$cnt_data=count($data[$i]);for($j=0;$j<$cnt_data;$j++){
		//si es un array bidimensional, genera data
			switch(isset($data[$i][$j])):case(true):$new_data[]=$data[$i][$j];break;endswitch;
			//de lo contrario, si es un array unidimensional, cuya llave es un unique ID tambien genera data
			switch(isset($data[$j])):
				case(true):
					switch(key($data[$i])==true):
					case(true):$new_data[][key($data[$i])]=implode("",$data[$i]);break;endswitch;
					//de lo contrario, comprobamos que existan al menos 6 registros para 1 array
					switch(count($data[$j])>2):
					case(true):$new_data[]=$data[$j];break;endswitch;
			$j=$cnt_data;
			break;endswitch;
			//de lo contrario, si key es null (db por defecto), tambien es correcto
			//si ciclo principal $i encuentra nulo (dentro de ciclo $j), agregamos la data de $i a $new_data, y saltamos pos de $i terminando ciclo de $j
			switch($data[$i]["dbid"]):
				case("null"):$new_data[]=($data[$i]);$j=$cnt_data;
			break;endswitch;
	//cierre ciclo $j
	}
//cierre ciclo $i
}
unset($nreg,$cnt_data,$i,$j,$data);
$data=$new_data;
//si no genera nueva data, y programa continua, significa que variable no es array
if (!isset($data)) return false;
unset($new_data);
return $data;
}

//recibe array con data duplicada y retorna array con data no duplicada
function arr_unique($arr) {
$cnt_data=count($arr);$ant=null;
//retorna array unico en $arr_dep
for($i=0;$i<$cnt_data;$i++){switch($arr[$i]):case((true) && $arr[$i]!=$ant):$arr_dep[]=$arr[$i];$ant=$arr[$i];break;endswitch;}unset($arr,$cnt_data,$i,$ant);return $arr_dep;
}

//BD
function db_show($dataarg){
global $separador;global $sep_int;$data=decrypt_db($dataarg);$check_fid=0;$check_table=0;
//formato en memoria $data es ds_dbid:null00-00null00-00tkey:null00-00null00-00dbfid:null00-00null00-00pk0ai0-+//+-rs_fid:null00-00fval:pk1ai000-00Bereta-+//+-rs_fid:null00-00fval:pk1ai100-00string_data[auto_incr]-+//+-
//para $data creamos nuevo array donde solo definimos la estructura de la BD, filtrando solo por ds_dbid:...
$data=(explode($separador,$data));$cnt_data=count($data);
for($i=0;$i<$cnt_data-1;$i++){
//si $data[$i] es ds_dbid:...
switch($data[$i]):case(strstr($data[$i],"ds_dbid")):$temp[]=explode($sep_int,$data[$i]);break;case(strstr($data[$i],"rs_fid")):$rs[]=explode($sep_int,$data[$i]);break;endswitch;
}
//si no hay datos en memoria, error
if (!isset($temp)) { echo 'data invalida en memoria, re-ingrese la BD'; exit(); }
//enumera cantidad de registros contenidos en campo
$cnt_reg=0;
if(isset($rs)) $nrsfid=count($rs);
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
								switch($dbid):
								case(($tab_j[2]) && ($dbid==$tab[2]) && ($tab_j[0]==$tab[0]) ):
									echo "<font color='red' size='+1'>Tabla:[<b>".$tab_j[1]."</b>]</font><p></p>";
									//mientras estamos aca, abrimos otro ciclo, para asociar los field ids
									for($f=0;$f<$nreg;$f++){
										//fid actual $fdata[0] / tkey asociado $fdata[1]
										$fdata=explode($sep_int,$fd[$f]);
										$fid_f=substr($fdata[0],6);
										//ciclo para obtener total de registros
											//si hay registros, los mostramos
											switch(!isset($nrsfid)):
											case(false):
											for($jp=0;$jp<$nrsfid;$jp++){
											//cada field id de ciclo rs que coincida con ciclo $f externo..
											$fid_int=substr($rs[$jp][0],7);
												switch($fid_int):case($fid_f):$cnt_reg=$cnt_reg+1;endswitch;
											//$fin ciclo $jp
											}
											break;endswitch;
										//si field ids coinciden 
										switch($fdata[1]):
											case($tab[0]):
												if(!$cnt_reg) $cnt_reg=0;
												echo "<font color='blue' size='-1'>Campo: [<b>".$temp[$f][5]."</b>] - Registro(s): [<a href=javascript:popUp('./gui/navigate_data/show_data.php?det=".$temp[$f][4].$sep_int.$dbname.$sep_int.$temp[$f][3].$sep_int.$temp[$f][5].$sep_int.$temp[$f][6]."')>".$cnt_reg."</a>]</font><p></p>";
												break;
										endswitch;
										//fin si field ids coinciden
									//al terminar el ciclo de n campos, limpiamos variable $cnt_reg (tot de registros)
									$cnt_reg=null;
									//fin ciclo field id
									}
								//si encontramos una tabla, matamos el ciclo n tablas de inmediato
								$j=$nreg;
								break;endswitch;
								//fin si tabla actual de ciclo $i coincide con ciclo tablas de $j
								}
					//fin ciclo tablas unicas de $i
					}
				echo "</td></table><table border='3'>";
				//fin gui DB
				}
	//fin gui
	echo "</center>";
//fin funcion
}

//formato correcto de lectura de data, de lo contrario error:
function table_sh($data){
//$data == $_SESSION["c_data_temp"][POS]
global $separador;global $sep_int;$check_table=0;
//keep arrays tidy
$data=temp2data($data);
echo "<center>";
$cnt_data=count($data);
//tablas unicas $arr[pos]=>value
$u_data=arr_unique($data);
//ciclo tabla unica (1 ciclo para cada tabla no duplicada en su tkey)
	for($i=0;$i<count($u_data);$i++){
		//tkey
		$tkey_i=$u_data[$i];
			//ciclo tablas duplicadas (n tablas duplicadas su tkey para unicos fid)
			for($j=0;$j<$cnt_data;$j++){
					//$tdata_j[0] tname / $tdata_j[1] fid / $tdata_j[2] fname / $tdata_j[3] fvalue
					$tdata_j=explode($sep_int,(implode('',$data[$j])));
					$tkey_j=key($data[$j]);
					switch($tkey_i):
					case(($tkey_j) && $check_table==0):
						echo "<font size='+3'>Tabla: [<b><font color='blue'>".$tdata_j[0]."</font></b>] </font><p></p>";
						$check_table=1;
					break;endswitch;
					//ciclo campos (n tkey(1 tkey) -> fid(externo) == fid n registros (interno de ciclo campos))
						for($f=0;$f<$cnt_data;$f++){
							//extraemos tname desde key $i
							$tkey_f=key($data[$f]);
							//$tdata_f[0] tname / $tdata_f[1] fid / $tdata_f[2] fname / $tdata_f[3] / fvalue
							$tdata_f=explode($sep_int,(implode('',$data[$f])));
							//si field id y tkey coinciden
								switch($tdata_f[1]):case(($tdata_j[1])&&($tkey_i==$tkey_j)):echo "<font size='-2'>Nombre Campo:</font> [<font color='green'><b>".$tdata_f[2]."</b></font>]<p></p>";break;endswitch;
						//fin ciclo campo
						}
			//fin ciclo tabla duplicada
			}
	//al finalizar ciclo de 1 tabla unica->n tablas, reiniciamos flag para mostrar tabla o no
	$check_table=0;		
	//fin ciclo tabla unica
	}
echo "</center>";
//fin funcion table show
}
//guarda en archivo txt permanentemente la DB
function save_data($data){
global $usuario_total,$contras_total,$ruta_ftp,$dir_remota,$ruta_http,$filedr,$db_nm,$cid,$resultado;
if($_SESSION['ftp_disabled']==0){
	//validamos que datos en memoria sean correctos
	decrypt_db($data);
	echo "<link rel='stylesheet' type='text/css' href='../libs/DWStyle.css' />";
	//Comprobamos que se creo el Id de conexión y se pudo hacer el login
	if((!$cid)||(!$resultado)){ 
		echo "<b>Fallo en la conexión. <font color='red'>Usuario / Contraseña incorrectos, o timeout de coneccion FTP</font> </b>"; die;
	//fin error coneccion ftp
	}
	else{
		//si cambiamos a modo pasivo, correctamente, continuamos
		if(ftp_pasv($cid, true)==true){
			echo "<br> Cambio a modo pasivo... <font color='green'>OK</font>. <b>".$dir_remota.$filedr.$db_nm."</b><br/>"; 
		//fin cambio modo pasivo ok
		}
		//de lo contrario error
		else{
		echo "<br> Cambio a modo pasivo... <font color='red'>ERROR</font><br />. Destino inalcanzable por el momento.";
		//fin error
		}
	//fin coneccion ftp OK
	}
	//ruta completa
	$ruta_http_completa=$ruta_http.$dir_remota;
	if (file_get_contents("http://".$ruta_http_completa,0,NULL,0,1) == FALSE)
	{
		if(ftp_close($cid)==true) echo "<p></p><font color='green'><b>Transacciones FTP finalizadas correctamente!!</b></font><p></p>";
			echo "<br> Ruta $ruta_http_completa <font color='red'><b>ERROR</b></font><br/><p></p>";
			echo "<font color='red'><b>la ruta $ruta_http_completa no existe, contacte al administrador para solucionar el problema.</b></font>";
			exit();
			//fin no existe ruta
		}
	//si el archivo existe en ruta destino, lo eliminamos y creamos uno nuevo
	else{
	echo "<b>Archivo DB encriptado, existe en: (<font color='blue'>".$ruta_http_completa.$filedr.$db_nm."</font>) <font color='green'><b>OK</font></b><p></p>";
	//si eliminamos el archivo... continuamos
		if(ftp_delete($cid,$dir_remota.$filedr.$db_nm)==true){
			echo "<b>PASO 1 de 2!<font color='green'>OK</font></b><p></p>";
			//volcamos encriptado a $data
			$data=$_SESSION['data_main'];
			//creamos puntero a memoria temporal "php://temp"
			$temp=fopen('php://temp', 'r+');
			//escribimos string a memoria temporal
			fwrite($temp, $data);
			//situamos memoria temporal a 0
			rewind($temp);        
				//si guardamos el nuevo archivo db.txt... actualizamos el contenido
				if(ftp_fput($cid,$dir_remota.$filedr.$db_nm,$temp, FTP_BINARY)==true){
					echo "<b>PASO 2 de 2!<font color='green'>OK</font></b><p></p>";
					echo "<table border='1'><td><font color='blue'><b>El archivo de Base de Datos ha sido actualizado satisfactoriamente!! </b></font></td></table><p></p>";
						if(ftp_close($cid)==true) echo "<p></p><font color='green'><b>Transacciones FTP finalizadas correctamente!!</b></font><p></p>";
					echo "<a href='javascript:window.close()'>Cerrar Ventana</a>";
				//fin si guardamos nuevo archivo en ftp
				}
				//de lo contrario, error al crear nuevo archivo
				else{
				echo "<b>PASO 2 de 2![creando el nuevo archivo ".$dir_remota.$filedr.$db_nm."] en FTP <font color='red'>ERROR</font></b><p></p>";
					if(ftp_close($cid)==true) echo "<p></p><font color='green'><b>Transacciones FTP cerradas correctamente!!</b></font><p></p>";
				}
		//fin elimina archivo
		}
		//de lo contrario, error al eliminar el archivo
		else{
		echo "<b>PASO 1 de 2![eliminando el archivo ".$nom_arch_ftp." en ".$dir_remota."] en FTP <font color='red'>ERROR</font></b><p></p>";
			if(ftp_close($cid)==true) echo "<p></p><font color='green'><b>Transacciones FTP finalizadas correctamente!!</b></font><p></p>";
		}
	//fin existe ruta destino
	}
	echo "</center>";
	//fin coneccion ftp habilitada
	}
	//de lo contrario, escribimos dato local de DB
	else if($_SESSION['ftp_disabled']==1){
	global $separador;
	//desencriptamos y organizamos estructuras ds_struct.ds_struct_n.rs_struct.rs_struct_n
	$data=decrypt_db($_SESSION['data_main']);
	//si la data tiene mas de 10 caracteres (es string)
	if(strlen($data)>10){
	$enc=(encrypt($data));
	$dump=$enc['encoded'].$separador.$enc['w_del'].$separador.$enc['password'];
	unset($data,$enc);
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=db".date("d")."".date("m")."".date("y").".txt");
	header("Content-Transfer-Encoding: binary");
	echo $dump;
	//fin si data tiene mas de 10 caracteres (string)
	}
	//fin si hay coneccion local
	}
//fin guardar datos permanentes en ftp / exportar archivo si LOCAL
}

//exporta data DB automaticamente basado en $string ingresado (encriptado DB en memoria)
function exp_data($data){
error_reporting(0);global $separador;$val=NULL;$data=decrypt_db($data);switch(strlen($data)>10):case(true):$enc=(encrypt($data));$dump=$enc['encoded'].$separador.$enc['w_del'].$separador.$enc['password'];unset($data,$enc);header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=db".date("d")."".date("m")."".date("y").".txt");header("Content-Transfer-Encoding: binary");echo $dump;break;endswitch;
}

//exporta bd basado en string input desencriptado (por ej: de DB)
//build_db(data,0) local / build_db(data,1) ftp
function build_db($data,$par){
global $separador,$usuario_total,$contras_total,$ruta_ftp,$dir_remota,$filedr,$db_nm;
error_reporting(0);$enc=(encrypt($data));$dump=$enc['encoded'].$separador.$enc['w_del'].$separador.$enc['password'];unset($data,$enc);
//ftp?
if($par==1){
//1. file create (temp)
$cnt_wrd=strlen($dump);
$fh=fopen("php://temp","w+");
fwrite($fh,$dump,$cnt_wrd);fseek($fh,0);
//2. ftp conn
$cid=ftp_connect($ruta_ftp);
$resultado=ftp_login($cid, $usuario_total ,$contras_total);
if ((!$cid) || (!$resultado)){echo "<font color='red'><b>ERROR, NO HAY INTERNET. No se puede crear la BD sin internet.</b></font>";}
else{
if(ftp_pasv ($cid, true)) echo "ftp modo pasivo ok!";
//3.create db
if(ftp_fput($cid,$dir_remota.$filedr.$db_nm,$fh, FTP_BINARY )==true) { fclose($fh); return true;}
else {echo "<b>BD no creada en servidor. No hay acceso a internet o problemas con FTP.</b>"; exit(); }
}

return true;
}
//local?
else {header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=db".date("d")."".date("m")."".date("y").".txt");header("Content-Transfer-Encoding: binary");echo $dump;}
//fin
}

//remueve DB en servidor FTP
function destroy_data($data){
global $usuario_total,$contras_total,$ruta_ftp,$dir_remota,$ruta_http,$filedr,$db_nm,$cid,$resultado;
//validamos que datos en memoria sean correctos
decrypt_db($data);
echo "<link rel='stylesheet' type='text/css' href='../libs/DWStyle.css' />";
echo "<center>";
//si datos de ingreso son correctos, continuamos
//si cambiamos a modo pasivo, correctamente, continuamos
if(ftp_pasv($cid, true)==true){
echo "<br> Cambio a modo pasivo... <font color='green'>OK</font><br />"; 
$ruta_http_completa=$ruta_http.$dir_remota;
}
//de lo contrario
else{
echo "<br> Cambio a modo pasivo... <font color='red'>ERROR</font><br />. Destino inalcanzable por el momento.";
}
//ruta completa
//Valida que el directorio $ruta_http_completa (directorio http destino de avatar) exista, de lo contrario habrá error.
if (file_get_contents("http://".$ruta_http_completa,0,NULL,0,1) == FALSE){
echo "<br> Ruta $ruta_http_completa <font color='red'><b>ERROR</b></font><br/><p></p>";
echo "<font color='red'><b>la ruta $ruta_http_completa no existe, contacte al administrador para solucionar el problema.</b></font>";
exit();
}
//si el archivo existe en ruta destino, lo eliminamos y creamos uno nuevo
else{
echo "<b>Archivo DB encriptado, existe en: (<font color='blue'>$ruta_http_completa</font>) <font color='green'><b>OK</font></b><p></p>";
//si eliminamos el archivo... continuamos
if(ftp_delete($cid,$dir_remota.$filedr.$db_nm)==true){
echo "<b>Archivo BD f&iacute;sico (<font color='blue'>".$dir_remota.$filedr.$db_nm."</font>) ha sido eliminado del servidor! [<font color='green'><b>OK</font>]</b><p></p>";
echo "<a href='javascript:window.close();'>Cerrar Ventana</a>";
unset($_SESSION['data_main']);
}
else{
echo "<b>Error al eliminar fichero DB desde el servidor: Ruta->(<b>".$dir_remota.$filedr.$db_nm."</b>. En este lapso alguien ya lo borr&oacute por t&iacute;";
echo "<a href='javascript:window.close();'>Cerrar Ventana</a>";
}
if(ftp_close($cid)==true) echo "<p></p><font color='green'><b>Transacciones FTP finalizadas correctamente!!</b></font><p></p>";
//fin si archivo existe en servidor
}
//fin delete ftp db
}

//funcion gui, muestra datos de db (vista)
function sh_data($data,$arg){
global $separador; global $sep_int; global $fdefdata; $db=null;
//flag que avisa si encontramos o no un registro
$exist=0;
//cont registros duplicados
$dupreg=0;
$output=explode($separador,$data);$dec=decrypt($output[0],$output[2],$output[1]);$dbfid=null;
switch($dec["pw_status"]=="OK"):case(true):
	$dec=explode($separador,$dec['decrypted']);$cnt_dec=count($dec);
	for($i=0;$i<$cnt_dec-1;$i++){
	// 0 =>'ds_dbid:null' // 1 =>'null' // 2 =>'tkey:null' // 3 =>'null' // 4 =>'dbfid:null' // 5 =>'null' // 6 =>'pk0ai0'
		$dump=explode($sep_int,$dec[$i]);
		switch ($dump):
			//validacion de desencripcion correcta, pero armado de data incorrecta error (cambio de formato en estructura de archivos)
			//rs_fid: posee hasta 4 reg, mientras que dbid hasta 7
			case(count($dump)<2):
				echo "<center>Error, la desencripci&oacute;n fue correcta, pero al construir la data en memoria tiene incompatibilidades. Detalles:<b>$dump</b>";
				echo "<p></p>Reconstruye la estructura para <b>".$dump[0]."</b>. (requiere crear una nueva BD y encriptarla)<p></p>";
				echo "usando la estructura siguiente: <b>ds_dbid:null".$sep_int."null".$sep_int."tkey:null".$sep_int."null".$sep_int."dbfid:null".$sep_int."null".$sep_int.$fdefdata.$separador."<p></p>";
				echo "</center>";
				exit();
			break;
			//abrimos n estructuras de BD(dbid), las guardamos en memoria y las comparamos contra nuevos y posibles registros(rs_fid)
			case(strstr($dump[0],"ds_dbid:")==true):
				$dbfid[]=($dump[4]);
			break;
			//si es (de lo contrario), un registro, lo apilamos
			case(strstr($dump[0],"rs_fid:")==true):
				//$rsdata[pos][0] fid / $rsdata[pos][1] reg data / $rsdata[pos][2] reg values  
				$rsdata[]=$dump;
			break;endswitch;
		//fin ciclo carga datos
		}
	unset($dec);
	//extraemos campos desde argumento
	//$arg[0] fid / $arg[1] dbname / $arg[2] tname / $arg[3] field name / $arg[4] field values
	$arg=explode($sep_int,$arg);
	//solo field ids unicos
	$dbfid=arr_unique($dbfid);
	//gui
	echo "<center>";
	//(solo si existe estructura de db)
	//ahora con los datos generados en memoria, consultamos el fid de $arg. Si existe, mostramos todos los registros (fid->reg)
	switch(isset($dbfid)):
	case(true):$cnt_dbfid=count($dbfid);
	for($i=0;$i<$cnt_dbfid;$i++){
		//db:fid fid debe coincidir 
		switch($dbfid[$i]):
			//si el registro se encuentra(fid), mostramos datos
			case($arg[0]):
			//solo si existe la estructura, se imprime
				echo "<font size='+3'><b>Estructura de BD actual:</b></font>";
				echo "<table border='2' bgcolor='#DDDFFF'><td>-></b><font color='blue' size='-1'>Nombre BD:</font><font color='green' size='-1'><b>[".$arg[1]."]</font> -></b> <font color='blue' size='-1'>Tabla:</font><font color='green' size='-1'><b>[".$arg[2]."]</font> -></b> <font color='blue' size='-1'>Campo:</font><font color='green' size='-1'><b>[".$arg[3]."]</b></font></td></table>";
				echo "<p></p>";
				echo "<font size='+3'><b>Datos:</b></font><p></p>[<font size='-1'><--Opciones de Registro -- Dato Almacenado --></font>]<p></p><table border='1' bgcolor='#DDDFFF'><td><center>";
				//segundo ciclo, enumera datos asociados a FID
					$fid=substr($dbfid[$i],6);
					switch(isset($rsdata)):case(true):for($j=0;$j<count($rsdata);$j++){
						//$rsdata[pos][0] reg fid assoc / $rsdata[pos][1] reg data / $rsdata[pos][2] reg values
						switch(substr($rsdata[$j][0],7)):case($fid):
							//revisa si duplicado (oculto para el usuario) -> tfid : rs_fidxxxxxxxx
								switch(strstr($rsdata[$j][1],"rs_fid:".$fid)):
								case(true):$fdata=substr($rsdata[$j][1],0,strlen($rsdata[$j][1])-strlen($fid)-strlen(uniq())-7);$exist++;
									echo "<font size='-2'>[<a href=''>Modificar</a>&nbsp;<a href=''>Eliminar</a>-->]</font><font size='+1' color='brown'>(<b>".$fdata.")</b><b><font color='red'> [$exist] </font></b></font></b><p></p>";
								break;
								case(false):$fdata=$rsdata[$j][1];
									echo "<font size='-2'>[<a href=''>Modificar</a>&nbsp;<a href=''>Eliminar</a>-->]</font><font size='+1' color='brown'>(<b>".$fdata.")</b></font></b><p></p>";
								break;endswitch;
						break;endswitch;
					//fin ciclo $j
					}
					//fin si reg data
					break;endswitch;
				if($fdata==false) echo "<b>No hay registros ingresados en el sistema!</b><p></p>";
				echo "</td></table></center><center><a href='javascript:window.close()'>Cerrar Ventana</a>";
			//una vez tengamos la estructura definida, matamos ciclo $i
			$i=$cnt_dbfid;
			break;
		endswitch;
	//fin ciclo $i
	}
	//cierre gui
	echo "</center>";
	break;endswitch;
	//si no existe, error. El dato ya fue modificado en memoria
	switch(!isset($dbfid)):
		case(true):echo "<center><b>No se encontraron estructuras de la base de datos. Posiblemente fueron eliminadas en este instante.<p></p> La estructura se obtiene desde la opcion (Reconstruir y Exportar una BD con el formato correcto)</b>.";echo "<p></p>";echo "<a href='javascript:window.close()'>Cerrar Ventana</a></center>";break;endswitch;
	switch(!isset($rsdata)):
		case(true):echo "<center><b>No se encontraron registros en el sistema. Debes ingresar uno al menos.</b>.";echo "<p></p>";echo "<a href='javascript:window.close()'>Cerrar Ventana</a></center>";break;endswitch;
	//fin si decr OK
	break;endswitch;
//fin funcion
}

//recibimos objeto del formulario y deriva a lo que corresponde
function dep_data($object){
//si borramos field id, limpiamos y enviamos nombre
if ($new=str_replace("__elim_fid","",$object)){
return elim_data($new,"fid");
}
}

//ordena y cachea data (solo registros, por id), requiere decrypt_bd($sesion con DB encriptada)
function cache_regstr($data){global $separador; global $sep_int;$data=(explode($separador,$data));$cnt_data=count($data);for($i=0;$i<$cnt_data-1;$i++){switch(substr($data[$i],0,2)):case("rs"):$tmp=(explode($sep_int,substr($data[$i],7)));$store[]=$tmp[0];$tmp=null;break;endswitch;}return $store;}

//ordena y cachea data (solo struct db, por id), requiere decrypt_bd($sesion con DB encriptada)
function cache_dbstr($data){global $separador; global $sep_int;$data=(explode($separador,$data));$cnt_data=count($data);for($i=0;$i<$cnt_data-1;$i++){switch(substr($data[$i],0,2)):case("ds"):$store[]=explode($sep_int,$data[$i]);$tmp=null;break;endswitch;}return $store;}

//version muestra modificar tablas
function dbsh_modif_table($dataarg){
global $separador;global $sep_int;$data=decrypt_db($dataarg);$check_fid=0;$check_table=0;
//currently stored dbid
$holder=$_SESSION['cur_db'];
//formato en memoria $data es ds_dbid:null00-00null00-00tkey:null00-00null00-00dbfid:null00-00null00-00pk0ai0-+//+-rs_fid:null00-00fval:pk1ai000-00Bereta-+//+-rs_fid:null00-00fval:pk1ai100-00string_data[auto_incr]-+//+-
//para $data creamos nuevo array donde solo definimos la estructura de la BD, filtrando solo por ds_dbid:...
$data=(explode($separador,$data));$cnt_data=count($data);for($i=0;$i<$cnt_data-1;$i++){
// $temp(1 dbid : n tablas) <-(if data source $holder[0] dbid <-> $data[$i] db buffer == true)
switch($data[$i]):case(strstr($data[$i],$holder[0])):$temp[]=explode($sep_int,$data[$i]);break;case(strstr($data[$i],"rs_fid")):$rs[]=explode($sep_int,$data[$i]);break;endswitch;
}
//enumera cantidad de registros contenidos en campo
$cnt_reg=0;switch(!isset($rs)):case(true):$nrsfid=0;break;case(false):$nrsfid=count($rs);break;endswitch;
//si no hay datos en memoria, error
if (!isset($temp)) { echo 'data invalida en memoria, re-ingrese la BD'; exit(); }
//gui
echo "<center>";$nreg=count($temp);for($i=0;$i<$nreg;$i++){$db[$temp[$i][0]]=$temp[$i][1];}for($i=0;$i<$nreg;$i++){$tk[]=$temp[$i][2].$sep_int.$temp[$i][3].$sep_int.$temp[$i][0];}
for($i=0;$i<$nreg;$i++){$fd[]=$temp[$i][4].$sep_int.$temp[$i][2];}$data=null;$tdata=arr_unique($tk);$tk_uniq=arr_unique($tk);$cnt_tk=count($tk_uniq);$cnt_fd=count($fd);
//gui db, no me sirve crear ciclos para mas datos aca, porque enumera cantidad de BD, y no cantidad de registros en total
echo "<form method='post' action='update.php'>";
foreach($db as $dbid=>$dbname){
	//hidden valuess
	echo "<input type='hidden' name='hid_dbid' value='".$dbid."'>";
	//cant reg (db & tab)
	echo "<input type='hidden' name='hid_nreg' value='".$nreg."'>";
	//imprime DB ($dbid dbid, $dbname dbname)

		//contar tablas unicas, crear un ciclo y compararlas contra cant de tablas
		for($i=0;$i<$cnt_tk;$i++){
			//tab 0 tkey , tab 1 tname, tab 2 dbid
			$tab=explode($sep_int,$tk_uniq[$i]);
				//segundo ciclo, comprueba 1 para n valores de la tabla, asociados a su tkey y current DBID
				for($j=0;$j<$nreg;$j++){
					//[0] tkey / [1] tname / [2] dbid
					$tab_j=explode($sep_int,$tk[$j]);
					switch($dbid):case(($tab_j[2]) && ($dbid==$tab[2]) && ($tab_j[0]==$tab[0])):
					//$tab_j[2] id_tabla
					echo "<table border='4'><td><font color='red'>Tabla:</red></font><input type='text' name='txt_tname' value='".$tab_j[1]."'> <p></p>";
						//mientras estamos aca, abrimos otro ciclo, para asociar los field ids
							for($f=0;$f<$nreg;$f++){
								//fid actual $fdata[0] / tkey asociado $fdata[1]
								$fdata=explode($sep_int,$fd[$f]);$fid_f=substr($fdata[0],6);
									for($jp=0;$jp<$nrsfid;$jp++){
											//cada field id de ciclo rs que coincida con ciclo $f externo..
											$fid_int=substr($rs[$jp][0],7);
												switch($fid_int):case($fid_f):$cnt_reg=$cnt_reg+1;break;endswitch;
											}
								//si field ids coinciden 
								switch($fdata[1]):
									case($tab[0]):
										if(!$cnt_reg) $cnt_reg=0;
										echo "<font color='blue' size='-1'>Campo:<input type='text' name='txt_campo".$j."' value='".$temp[$f][5]."'> - Registro(s): [".$cnt_reg."]</font><p></p>";
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
				break;endswitch;
				//fin ciclo n tablas de $j
				}
		echo "</table>";
		//fin ciclo tablas unicas de $i
		}
//fin gui DB
}
echo "</center><p></p>";
//fin funcion
}
?>