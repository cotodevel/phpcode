<?php
include '../../../class.php';
//field id (crear reg_data asociado a este fid)
$fid=($_POST['hid_fid']);
//campos de valores
if(isset($_POST['txt_reg_1'])){
$txt_reg_1=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_1'])));
	//si es entero
	if(isset($_POST['chk_int_1'])) $txt_reg_1.=$fdefdata."int1";
	else $txt_reg_1.=$fdefdata."int0";
$txt_reg[]=$txt_reg_1;	
}
if(isset($_POST['txt_reg_2'])){
$txt_reg_2=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_2'])));
	//si es entero
	if(isset($_POST['chk_int_2'])) $txt_reg_2.=$fdefdata."int1";
	else $txt_reg_2.=$fdefdata."int0";
$txt_reg[]=$txt_reg_2;
}
if(isset($_POST['txt_reg_3'])){
$txt_reg_3=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_3'])));
	//si es entero
	if(isset($_POST['chk_int_3'])) $txt_reg_3.=$fdefdata."int1";
	else $txt_reg_3.=$fdefdata."int0";
$txt_reg[]=$txt_reg_3;
}
if(isset($_POST['txt_reg_4'])){
$txt_reg_4=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_4'])));
	//si es entero
	if(isset($_POST['chk_int_4'])) $txt_reg_4.=$fdefdata."int1";
	else $txt_reg_4.=$fdefdata."int0";
$txt_reg[]=$txt_reg_4;
}
if(isset($_POST['txt_reg_5'])){
$txt_reg_5=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_5'])));
	//si es entero
	if(isset($_POST['chk_int_5'])) $txt_reg_5.=$fdefdata."int1";
	else $txt_reg_5.=$fdefdata."int0";
$txt_reg[]=$txt_reg_5;
}
if(isset($_POST['txt_reg_6'])){
$txt_reg_6=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_6'])));
	//si es entero
	if(isset($_POST['chk_int_6'])) $txt_reg_6.=$fdefdata."int1";
	else $txt_reg_6.=$fdefdata."int0";
$txt_reg[]=$txt_reg_6;
}
if(isset($_POST['txt_reg_7'])){
$txt_reg_7=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_7'])));
	//si es entero
	if(isset($_POST['chk_int_7'])) $txt_reg_7.=$fdefdata."int1";
	else $txt_reg_7.=$fdefdata."int0";
$txt_reg[]=$txt_reg_7;
}
if(isset($_POST['txt_reg_8'])){
$txt_reg_8=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_8'])));
	//si es entero
	if(isset($_POST['chk_int_8'])) $txt_reg_8.=$fdefdata."int1";
	else $txt_reg_8.=$fdefdata."int0";
$txt_reg[]=$txt_reg_8;
}
if(isset($_POST['txt_reg_9'])){
$txt_reg_9=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_9'])));
	//si es entero
	if(isset($_POST['chk_int_9'])) $txt_reg_9.=$fdefdata."int1";
	else $txt_reg_9.=$fdefdata."int0";
$txt_reg[]=$txt_reg_9;
}
if(isset($_POST['txt_reg_10'])){
$txt_reg_10=trim(strtolower(preg_replace('/\s+/','_', $_POST['txt_reg_10'])));
	//si es entero
	if(isset($_POST['chk_int_10'])) $txt_reg_10.=$fdefdata."int1";
	else $txt_reg_10.=$fdefdata."int0";
$txt_reg[]=$txt_reg_10;
}
//data debe ser desencriptada desde memoria
$data_dbmem=null;$data_dbmem=(decrypt_db($_SESSION['data_main']));$data_dbmem=(explode($separador,$data_dbmem));$cnt_dbmem=count($data_dbmem);
//contador para pos db struct
$int_ds=0;
//contador para pos reg struct
$int_rs=0;
$ds_st=null;
//flag que define si data existe para 1 fid-> n reg 
$data_existe=0;
//rs holder
$rs_st=null;
//recorremos n db/reg structs
for($i=0;$i<$cnt_dbmem-1;$i++){
	//linea db struct, reg struct
	$data=explode($sep_int,$data_dbmem[$i]);
	//por cada registro que cumpla con norma db struct
	if(strstr($data[0],"ds_dbid:")){
		$ds_st.=$data[0].$sep_int.$data[1].$sep_int.$data[2].$sep_int.$data[3].$sep_int.$data[4].$sep_int.$data[5].$sep_int.$data[6].$separador;
		$int_ds++;
	//cierre if norma ds db struct
	}
	//por cada registro que cumpla con norma reg struct
	else if(strstr($data[0],"rs_fid:")){
		//reemplazamos las llaves numericas por estructura
		//rs = fid sep data stp fval
		$rs[]=array("fid"=>$data[0],"data"=>$data[1],"fval"=>$data[2]);
		$int_rs++;
	//cierre reg norma reg struct
	}
//fin ciclo recorre n db/reg struct
}
//reinsercion de data anterior ordenada [1/2][convertir form anterior a estandar reg struct]
for($i=0;$i<count($txt_reg);$i++){
//muestre solo data=fdata+fvalues-cuenta fvalues, partiendo desde fdata
$fdata=substr($txt_reg[$i],0,strlen($txt_reg[$i])-10);
//muestre solo fvalues=fdata+fvalues, partiendo desde fvalues (substr parte desde ultima posicion inversa si valor de inicio es negativo)
$fval=substr($txt_reg[$i],strlen($fdata)-strlen($txt_reg[$i]));
$tfid=(str_replace("dbfid","rs_fid",$fid));

	//consultamos dato actual (de form anterior) si coincide con alguno que reside en memoria
	for($j=0;$j<$int_rs;$j++){
		//tfid dbfid->reg_fid (para comparar) contra cada reg_fid.data. (cada registro 
		switch($tfid.$fdata):
			case($rs[$j]["fid"].$rs[$j]["data"]):
				$fdata=$fdata.$tfid.uniq();
			break;
		endswitch;
	//fin for form anterior $j
	}
	//si no existe, continuamos
	$rs[]=array("fid"=>str_replace("dbfid:","rs_fid:",$fid),"data"=>$fdata,"fval"=>$fval);
//cierre ciclo $i (ciclo registros anteriores)
}
//parseamos array a estructura reg fis (rsfid) reg mem + reg anterior [2/2][insercion de data y estructura rs_fid]
for($i=0;$i<count($rs);$i++){
if(!isset($rs[$i]["n_inc"])) $rs_st.=$rs[$i]["fid"].$sep_int.$rs[$i]["data"].$sep_int.$rs[$i]["fval"].$separador; 
else $rs_st.=$rs[$i]["fid"].$sep_int.$rs[$i]["data"].$sep_int.$rs[$i]["fval"].$sep_int.$rs[$i]["n_inc"].$separador;
}
//fin data ingresada anteriormente
unset($rs,$ds,$i,$data,$data_tmem,$cnt_data_tmem,$int_ds,$int_rs,$txt_reg);
//$data lista y se encripta(dbfid+rsfid)
$enc=encrypt($ds_st.$rs_st);
//limpieza de memoria de tablas
unset($ds_st,$rs_st);
$data=$enc['encoded'].$separador.$enc['w_del'].$separador.$enc['password'];
if($_SESSION['data_main']=$data){
echo "<center><table border='1'><td><b>El registro ha sido ingresado correctamente!</b></td></table>";
echo "<p></p>";
echo "<a href='javascript:window.close()'>Cerrar Ventana</a></center>";
}
?>