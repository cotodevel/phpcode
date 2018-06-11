<?php
include '../../class.php';
$data=null;

//unique id (para table name)
$unique=uniq();

//flag que nos indica si el registro consultado ya existe en el sistema o no
$tabla_existe=0;

//nombre tabla
$tname=trim(strtolower(preg_replace('/\s+/','_',$_POST["txt_tname_1"])));

//si tiene etiqueta field value campo 1
if (isset($_POST["txt_fname_1"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_1"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_1"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_1"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}

//si tiene etiqueta field value campo 2
if (isset($_POST["txt_fname_2"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_2"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_2"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_2"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}
//si tiene etiqueta field value campo 3
if (isset($_POST["txt_fname_3"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_3"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_3"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_3"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}
//si tiene etiqueta field value campo 4
if (isset($_POST["txt_fname_4"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_4"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_4"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_4"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}
//si tiene etiqueta field value campo 5
if (isset($_POST["txt_fname_5"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_5"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_5"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_5"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}
//si tiene etiqueta field value campo 6
if (isset($_POST["txt_fname_6"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_6"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_6"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_6"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}
//si tiene etiqueta field value campo 7
if (isset($_POST["txt_fname_7"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_7"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_7"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_7"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}
//si tiene etiqueta field value campo 8
if (isset($_POST["txt_fname_8"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_8"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_8"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_8"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}
//si tiene etiqueta field value campo 9
if (isset($_POST["txt_fname_9"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_9"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_9"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_9"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}
//si tiene etiqueta field value campo 10
if (isset($_POST["txt_fname_10"])){
$fvalue=null;
//reemplazamos espacios por guien bajo "_"
$fname=trim(strtolower(preg_replace('/\s+/','_', $_POST["txt_fname_10"])));
//si es llave primaria, es registro padre
if(isset($_POST["chk_pk_fid_10"])) $fvalue="pk1";
else $fvalue="pk0";

//si es autoincremental el campo, se incrementa con registro ingresado con un entero a la vez
if(isset($_POST["chk_ai_fid_10"])) $fvalue.="ai1";
else $fvalue.="ai0";
$fdata[][$fname]=$fvalue;
$fvalue=null;
}

//al terminar, etiquetamos la tabla y la agregamos a memoria
$nfid=count($fdata);
for($i=0;$i<$nfid;$i++){
//field id se genera en este instante para 1 tabla
//key($fdata[$i]) [tname] / [field id] / [fname] / (implode("",$fdata[$i])) [fvalue]
$data[$i][$unique]=$tname.$sep_int.uniq().$sep_int.key($fdata[$i]).$sep_int.$fdefdata;
}

//SI SESION EXISTE
if (isset($_SESSION["c_data_temp"]))
{
//cargamos datos desde tablas a ingresar en memoria
//formato [array]
// 0 => 
//    array
//      '78386601595' => string 'tabla_1-+//+-campo_1ai:0' (length=24)
//  1 => 
//    array
//      '78386601595' => string 'tabla_1-+//+-campo_2ai:0' (length=24)
$newdata_tab=temp2data($_SESSION["c_data_temp"]);

//tot registros en memoria tabla temporal
$cnt_ndata_tab=count($newdata_tab);

//$data trae data de hoja anterior de tablas y field value id
//es posible que datos en memoria sean mayores o menores que data, por lo que tendremos que abrir otro ciclo para revisar cada dato ingresado e irlo comparando contra
//datos en memoria [en donde table name sea igual], para luego preguntar si field name es igual
$cnt_data_ant=count($data);

	//ciclo para n datos ingresados anteriormente en hoja
	for($j=0;$j<$cnt_data_ant;$j++){
		//key
		$tb_uid_gen=key($data[$j]);
		//$tfval_j[0] tname / $tfval_j[1] field id / $tfval_j[2] fname / $tfval_j[3] fvalues
		$tfval_j=(explode($sep_int,implode('',$data[$j])));
			//verificamos que en memoria tabla, uno de los campos no exista, 
			for($i=0;$i<$cnt_ndata_tab;$i++){
				//enumera datos de la memoria
				//$data_mem[0]==table name / $data_mem[1]==fid / $data_mem[2] fname / $data_mem[3] fvalue 
				$data_mem=explode($sep_int,implode('',$newdata_tab[$i]));
				//si hay un nombre de campo (field name) que coincide ya en una tabla ingresada anteriormente en memoria, error
				if($tfval_j[0]==$data_mem[0] && $data_mem[2]==$tfval_j[2]){
					echo "<center>Lo siento, ya existe un campo con el nombre de <font color='red'><b>".$tfval_j[2]."</b></font>, en la Tabla <font color='green'><b>".$tfval_j[0]."</b></font>. <p></p> Ingresa un nombre de campo diferente";
					echo "<p></p>";
					echo "<a href='javascript:history.go(-1)'>Volver</a></center>";
					exit();
				//fin si hay coincidencia de field names en tablas en memoria
				}
		
				//si intentamos ingresar un campo para una tabla ya existente en memoria no generamos nuevo tkey, sino que lo heredamos
				if($tname==$data_mem[0]){
					$tabla_existe=1;
					$tkey_recvd=key($newdata_tab[$i]);
				}
			//fin ciclo $i (tablas en memoria)
			}
	//fin ciclo $j (n datos ingresados en hoja anterior)
	}
	//si la tabla existe en memoria, recuperamos $tkey original e insertamos a $data el id $tkey_recvd
	if($tabla_existe==1){
		//abrimos $data
			foreach($data as $key=>$info){
				//editamos data introduciendo table key existente
				$data_new[][$tkey_recvd]=implode('',$info);
				//fin foreach
			}
	//volcamos
	$data_temp=($_SESSION["c_data_temp"]);
	$data_temp[]=$data_new;
	$_SESSION["c_data_temp"]=$data_temp;
	//fin si debemos reingresar tkey a dato existente
	}
	
	//si no existe la tabla en memoria, continuamos agregando
	else{
		//abrimos $data
			for($i=0;$i<count($data);$i++){
				//(key)714960014 => (string)'tabla_100-0071928001900-00campo_500-00pk0ai0'
				//tkey=> tname / fid / fname / fvalue
				$data_new[][key($data[$i])]=implode("",$data[$i]);
			}
	//volcamos
	$data_temp=$_SESSION["c_data_temp"];
	$data_temp[]=$data_new;
	$_SESSION["c_data_temp"]=$data_temp;
	//fin si $tabla_existe=0 (unique id generado para nueva tkey)
	}

echo "<center><table border='1'><td>Tabla <b>$tname</b> y <b>$nfid</b> campos fueron procesados en memoria!</td></table>";
echo "<p></p>";
echo "<a href='./add_table.php'>Crear una nueva tabla</a><p></p><a href='javascript:window.close()'>Cerrar Ventana!</a></center>";
unset($fid,$tname,$fvalue,$i,$data,$nfid,$data_new,$tkey_recvd,$data_temp);
//fin si sesion de memorias temporales existe
}

//SI NO EXISTE SESION, CREAMOS UNA
else{
//abrimos $data
for($i=0;$i<count($data);$i++){
//(key)714960014 => (string)'tabla_100-0071928001900-00campo_500-00pk0ai0'
//tkey=> tname / fid / fname / fvalue
$data_new[][key($data[$i])]=implode("",$data[$i]);
}
//volcamos
$_SESSION["c_data_temp"]=$data_new;
echo "<center><table border='1'><td>Tabla <b>$tname</b> y <b>$nfid</b> campos fueron procesados en memoria!</td></table>";
echo "<p></p>";
echo "<a href='./add_table.php'>Crear una nueva tabla</a><p></p><a href='javascript:window.close()'>Cerrar Ventana!</a></center>";
unset($fid,$tname,$fvalue,$i,$data,$nfid,$data_new,$tkey_recvd,$data_temp);
}
?>