<?php
//libs
include '../../class.php';
$db=null;
//id unico para DB (1 DB para n tablas)
$uniq_db=uniq();
//comprobamos que exista un archivo de tablas primero
if(isset($_SESSION["c_data_temp"])){
//recibe variable sanitizada
$db_input_n=trim(strtolower(preg_replace('/\s+/','_', $_POST["db_name"])));
//data debe ser desencriptada desde memoria
$data_dbmem=(decrypt_db($_SESSION['data_main']));
//ordenamos data
$data_dbmem=(explode($separador,$data_dbmem));
$cnt_dbmem=count($data_dbmem);
//contador para pos db struct
$int_ds=0;
//contador para pos reg struct
$int_rs=0;
//recorremos n db/reg structs
for($i=0;$i<$cnt_dbmem-1;$i++){
//linea db struct, reg struct
//$data_dbmem[$i];
$data=explode($sep_int,$data_dbmem[$i]);
//por cada registro que cumpla con norma db struct
if(strstr($data[0],"ds_dbid")){
$ds[$int_ds]["dbid"]=$data[0];
$ds[$int_ds]["dbname"]=$data[1];
$ds[$int_ds]["dbtkey"]=$data[2];
$ds[$int_ds]["dbtname"]=$data[3];
$ds[$int_ds]["dbfid"]=$data[4];
$ds[$int_ds]["dbfname"]=$data[5];
$ds[$int_ds]["dbfvalue"]=$data[6];
$int_ds++;
//cierre if norma ds db struct
}
//por cada registro que cumpla con norma reg struct
else if("rs_fid:"==substr($data[0],0,7)){
//reemplazamos las llaves numericas por estructura
$rs[$int_rs]["fid"]=$data[0];
$rs[$int_rs]["fval"]=$data[1];
$rs[$int_rs]["data"]=$data[2];
if(isset($data[3])) $rs[$int_rs]["n_inc"]=$data[3];
$int_rs++;
//cierre reg norma reg struct
}
//fin ciclo recorre n db/reg struct
}

//por cada registro que exista en data_main -> ds db struct...
for($i=0;$i<count($ds);$i++){
//verificar que no existan BD name duplicados
if($ds[$i]["dbname"]==$db_input_n)
{
echo "<center><table border='1'><td>Lo siento, Nombre de Base de datos <b>".$ds[$i]["dbname"]."</b> ya existe en el sistema, ingresa uno nuevo.!</td></table>";
echo "<p></p>";
echo "<a href='javascript:history.go(-1)'>Volver</a></center>";
exit();
//cierre ifverifica BD name duplicado
}
//cierre ciclo revisa N registros para BD
}
$data_p=null;

//procesamos cada linea desde memoria de tablas temporal
$data_tmem=$_SESSION["c_data_temp"];
$data_tmem=temp2data($data_tmem);
$cnt_data_tmem=count($data_tmem);
$next_tnfname=null;
//por cada registro en cola
for($i=0;$i<$cnt_data_tmem;$i++){
//unique tkey
$tkey=key($data_tmem[$i]);
//table name [0] // field id [1] // field name [2] // field values [3]
$tnfval=implode("",$data_tmem[$i]);
$tnfval=explode($sep_int,$tnfval);
$tkey=key($data_tmem[$i]);
//$tnfval[0] tname / $tnfval[1] field id / $tnfval[2] fname / $tnfval[3] fvalues

//estructura: dbid->dbname (1 - n) tkey ->tname (1 - n) dbfid -> dbfname (1 - n) fvalues (un field guarda n values) y se genera con values por defecto para fid [pk0ai0]
//dbid:uniqueid[1 para toda la DB]00-00null00-00tkey:uniqueid00-00null00-00dbfid:uniqueid00-00null00-00null-+//+-
$data_p.="ds_dbid:".$uniq_db.$sep_int.$db_input_n.$sep_int."tkey:".$tkey.$sep_int.$tnfval[0].$sep_int."dbfid:".$tnfval[1].$sep_int.$tnfval[2].$sep_int.'fval:'.$tnfval[3].$separador;
}

$ds_st=null;
//reinsercion de data cuyo orden es: ds struct[n]/separador/rs struct[n][1 de 2]
for($i=0;$i<count($ds);$i++){
//$ds_st concatena n ds struct en memoria
//array
//  'dbid' => string 'ds_dbid:null' (length=12)
//  'dbname' => string 'null' (length=4)
//  'dbtkey' => string 'tkey:null' (length=9)
//  'dbtname' => string 'null' (length=4)
//  'dbfid' => string 'dbfid:null' (length=10)
//  'dbfname' => string 'null' (length=4)
//  'dbfvalue' => string 'pk0ai0' (length=6)
$ds_st.=$ds[$i]["dbid"].$sep_int.$ds[$i]["dbname"].$sep_int.$ds[$i]["dbtkey"].$sep_int.$ds[$i]["dbtname"].$sep_int.$ds[$i]["dbfid"].$sep_int.$ds[$i]["dbfname"].$sep_int.$ds[$i]["dbfvalue"].$separador;
}
//fifo[primer dato que entra, primer dato que sale] para n ds db struct
$ds_st.=$data_p;

$rs_st=null;
//reinsercion de data cuyo orden es:  ds struct[n]/separador/rs struct[n][2 de 2]
for($i=0;$i<count($rs);$i++){
if(!isset($rs[$i]["n_inc"])) $rs_st.=$rs[$i]["fid"].$sep_int.$rs[$i]["fval"].$sep_int.$rs[$i]["data"].$separador; 
else $rs_st.=$rs[$i]["fid"].$sep_int.$rs[$i]["fval"].$sep_int.$rs[$i]["data"].$sep_int.$rs[$i]["n_inc"].$separador;
}
//y al terminar, pegamos n rs register structs
$ds_st.=$rs_st;
//$ds_st almacena ds db structs por orden de llegada [mas antiguo primero], luego rs reg structs por orden de llegada tambien, incluido el registro que ingresamos ahora
unset($rs_st,$rs,$ds,$i,$data,$data_tmem,$cnt_data_tmem,$tkey,$tnfname,$data_p);
//$data lista y se encripta
$enc=(encrypt($ds_st));
//limpieza de memoria de tablas
unset($ds_st,$_SESSION["c_data_temp"]);
$data=$enc['encoded'].$separador.$enc['w_del'].$separador.$enc['password'];
$_SESSION['data_main']=$data;
echo "<center><table border='1'><td><b>La BD en memoria ha sido actualizada correctamente!</b></td></table>";
echo "<p></p>";
echo "<a href='javascript:window.close()'>Cerrar Ventana</a></center>";
//fin si existe archivo de tablas en memoria
}
//de lo contrario, error
else{
echo "<center><table border='1'><td>Lo siento, no puedes agregar una base de datos, si no ingresas una tabla al menos.!</td></table>";
echo "<p></p>";
echo "<a href='javascript:history.go(-1)'>Volver</a></center>";
}
?>