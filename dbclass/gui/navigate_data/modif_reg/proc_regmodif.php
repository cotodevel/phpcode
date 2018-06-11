<?php
include '../../../class.php';
//field id (crear reg_data asociado a este fid)
$fid=($_POST['hid_fid']);
$cnt_reg=(int)$_GET['cnt_data'];
for($i=0;$i<$cnt_reg;$i++){
	//campos de valores
	if(isset($_POST[$fid.$i])){
		$txt_reg=trim(strtolower(preg_replace('/\s+/','_',$_POST[$fid.$i])));
			//si es entero
			if(isset($_POST['chk_int'.$i])) $txt_reg.=$fdefdata."int1";
			else $txt_reg.=$fdefdata."int0";
		$data[]=$txt_reg;	
	//fin si hay dato
	}
//fin ciclo recorre y agrupa datos a array $data
}
//OJO: Como ya cargamos total de registros de memoria, a modificar, ya tenemos validados datos no duplicados.
//Los unicos datos que debemos revisar que no sean duplicados, son los datos que ingresamos a continuación (desde form anterior)
//ciclo que revisa valores duplicados para registros en form anterior
//llevamos 1 frame de ventaja respecto al registro actual original ($txt_reg[$i])
for($i=0;$i<count($data);$i++){
	for($j=$i+1;$j<count($data);$j++){
		//nuestro valor duplicado actual
		switch($data[$j]):
			//Si registro original se repite al menos una vez, en n posiciones + 1, duplicado
			case($data[$i]):
				echo "<center>Lo siento, no puedes tener 2 o m&aacute;s datos -> ( <font color='red'><b>".substr($data[$j],0,strlen($data[$j])-10)."</b></font> ) id&eacute;nticos. <p></p>";
				echo "<p></p>";
				echo "<a href='javascript:history.go(-1)'>Volver</a></center>";
				exit();
				//matamos ciclo $j(si no hay duplicados para original, continuamos al siguiente ciclo $i)
				$j=count($data);
			break;
		endswitch;
	//cierre ciclo $j registros form anterior duplicados
	}
//cierra ciclo $i
}
$data_ant=$data;
unset($data);
//data debe ser desencriptada desde memoria
$data_dbmem=null;$data_dbmem=(decrypt_db($_SESSION['data_main']));$data_dbmem=(explode($separador,$data_dbmem));$cnt_dbmem=count($data_dbmem);
//contador para pos db struct
$int_ds=0;$int_rs=0;$ds_st=null;$rs_st=null;
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
	//[deshabilitado:] No necesitamos re ingresar data anterior (como cuando agregamos registros a data ya existente. 
	//Porque toda la data a procesar ya se encuentra en memoria
	//por cada registro que cumpla con norma reg struct
	//else if(strstr($data[0],"rs_fid:")){
		//reemplazamos las llaves numericas por estructura
		//rs = fid sep data stp fval
	//	$rs[]=array("fid"=>$data[0],"data"=>$data[1],"fval"=>$data[2]);
	//	$int_rs++;
	//cierre reg norma reg struct
	//}
//fin ciclo recorre n db/reg struct
}
//parseamos array a estructura reg fis (rsfid) reg mem + reg anterior [2/2][insercion de data y estructura rs_fid]
for($i=0;$i<count($data_ant);$i++){
$fdata=substr($data_ant[$i],0,$data_ant[$i]-10);
$fval=substr($data_ant[$i],strlen($data_ant[$i])-10);
$pk=substr($fval,0,3);
$ai=substr($fval,3,3);
$int=substr($fval,6,4);
//si no autoincrementa, solo guardamos fid,fdata y fval
if($ai!=1) $rs_st.=$fid.substr($_POST['hid_fid_n'],6-strlen($_POST['hid_fid_n'])).$sep_int.$fdata.$sep_int.$fval.$separador;
//de lo contrario guardamos auto_increment_n (ademas de fid,fdata y fval)
else $rs_st.=$fid.substr($_POST['hid_fid_n'],6-strlen($_POST['hid_fid_n'])).$sep_int.$fdata.$sep_int.$fval.$sep_int.substr($fval,-3,3).$separador;
}
//fin data ingresada anteriormente
unset($rs,$ds,$i,$data,$data_tmem,$cnt_data_tmem,$int_ds,$int_rs,$txt_reg);
//$data lista y se encripta(dbfid+rsfid)
$enc=encrypt($ds_st.$rs_st);
//limpieza de memoria de tablas
unset($ds_st,$rs_st);
$data=$enc['encoded'].$separador.$enc['w_del'].$separador.$enc['password'];
if($_SESSION['data_main']=$data){
echo "<center><table border='1'><td><b>El registro ha sido modificado correctamente!</b></td></table>";
echo "<p></p>";
echo "<a href='javascript:window.close()'>Cerrar Ventana</a></center>";
}
?>