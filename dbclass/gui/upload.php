<?php
echo "<body><center>";
//clases varias
include '../class.php';
//si es ftp..
if($_SESSION['ftp_disabled']==0){
	//antes de subir al servidor, verificamos que archivo sea desencriptado correctamente!
	$file=file_get_contents($_FILES['uploadedfile']['tmp_name']);
	$output=explode($separador,$file);
	if(count($output)>=2) {$dec=decrypt($output[0],$output[2],$output[1]);
	if($dec["pw_status"]=="OK"){
	//Validacion de espacios en blanco
	$arch_limpio=trim(strtolower(preg_replace('/\s+/', '_', $db_nm))); 
	//validacion de extension
	if(substr($db_nm,-3,3)!="txt") { echo "Error, el archivo no tiene el formato correcto (.txt) <p></p>"; echo "<p></p><a href='javascript:window.close()'>Cerrar Ventana</a>"; exit(); }
	echo "MODO FTP: Conectado al servidor (FTP)... y logueado... <font color='green'>OK</font><p></p>";		
	//Valida que el directorio $ruta_http_completa (directorio http destino de avatar) exista, de lo contrario habrá error.
	//ruta completa
	$ruta_http_completa=$ruta_http.$dir_remota.$filedr;
	//file retrieve
	$ftpdb=file_get_contents("ftp://".$usuario_total.":".$contras_total."@".$ruta_ftp.$dir_remota.$filedr.$db_nm,0,NULL,0,1);
	//if not exists, create then
	if ($ftpdb==false){
	//creamos y subimos db a ftp.[1 de 2]
	build_db("ds_dbid:null00-00null00-00tkey:null00-00null00-00dbfid:null00-00null00-00pk0ai0-+//+-rs_fid:null00-00Bereta00-00fval:pk1ai0",1);
	}
	
	//una vez el archivo estee cargado, cargarlo a la maquina y comprobar si fué desencriptado correctamente
	$file=(file_get_contents($_FILES['uploadedfile']['tmp_name']));
	//Si se sube el archivo, terminamos.
	if(ftp_put($cid,$dir_remota.$filedr.$db_nm,$_FILES['uploadedfile']['tmp_name'], FTP_BINARY )){
		echo ("<p></p>");
		echo "<b>El archivo ".$db_nm.", &nbsp <p></p> fu&eacute; subido <font color='green'> exit&oacute;samente</font> a la ruta: (<font color='blue'>".$dir_remota.$filedr.$db_nm.")</font>";
		//ahora la data encriptada es almacenada
		$_SESSION['data_main']=$file;
		echo "<p></p>";
		echo "*ESTADO: * <table border='1'><td><font color='blue'>BD desencriptada, y cargada en memoria correctamente!! <p><p> Ahora puedes trabajar con el motor de base de datos satisfactoriamente!</font></td></table>";
		echo "<p></p>";
		echo "<a href='javascript:window.close();'>Cerrar Ventana</font>";
		//limpieza
		unset($file,$nva_ruta,$ruta_file,$dir_remota,$arch_limpio,$cid,$resultado,$nom_arch,$dir_remota_http,$dir_remota_ftp,$ruta_ftp,$ruta_http);
		}
	//de lo contrario, error al subir el archivo
	else{
		echo "<font color='red'><b>Error subiendo archivo a internet por ftp: ruta (".$dir_remota.$filedr.$arch_limpio.")</b>.<p></p>";
		echo "o conecci&oacute;n interrumpida, o no hay conecci&oacute;n a internet, o el directorio ya no existe.</font>";
		echo "<p></p><a href='javascript:window.close()'>Cerrar Ventana</a>";
		}
	//fin si PW DECRYPT OK
	}
	//fin si array (dec) >= 2 (si es 1, explode retorna false)
	}
	//de lo contrario, error al desencriptar archivo local subido
	else{
	echo "<b>*ESTADO: * <table border='1'><td><font color='red'>ERROR decrypt_db(); el documento que subiste no pas&oacute; la prueba de verificacion </font></td></table></b>";
	echo "<p></p>";
	echo "<a href='javascript:window.close();'>Cerrar Ventana</a>";
	//fin error db decrypt
	}
//fin si es coneccion ftp
}
//si es coneccion local
else if($_SESSION['ftp_disabled']==1){
	$fname=($_FILES["uploadedfile"]["name"]);
	$ext_fname=(substr($fname,-3,3));
	//Si es un archivo de texto, se sube
	if ($ext_fname=="txt"){ 
		//rescata nombre de archivo
		$arch_limpio=trim(strtolower(preg_replace('/\s+/', '_', $_FILES["uploadedfile"]['name']))); 
		echo "<font color='green'><b>MODO LOCAL:</font> (directorio destino FTP no fue alcanzado)</b><p></p>";
		echo "la ruta fisica del archivo es: ".getcwd()."/".$arch_limpio;
		//antes de subir al servidor, verificamos que archivo sea desencriptado correctamente!
		$output=explode($separador,file_get_contents($_FILES['uploadedfile']['tmp_name']));
		$dec=decrypt($output[0],$output[2],$output[1]);
		
		//si desencripta correctamente, continuamos
		if($dec["pw_status"]=="OK"){
			$_SESSION['data_main']=file_get_contents($_FILES['uploadedfile']['tmp_name']);
			echo "<p></p>";
			echo "*ESTADO: * <table border='1'><td><font color='blue'>BD desencriptada (<b>".$arch_limpio."</b>), y cargada en memoria correctamente!! <p><p> Ahora puedes trabajar con el motor de base de datos satisfactoriamente!</font></td></table>";
			echo "<p></p>";
			echo "<a href='javascript:window.close();'>Cerrar Ventana</font>";
			//limpieza
			unset($arch_limpio,$output,$dec);
		}
		//de lo contrario, error al desencriptar archivo local subido
		else{
			echo "<b>*ESTADO: * <table border='1'><td><font color='red'>ERROR decrypt_db(); el documento que subiste no pas&oacute; la prueba de verificacion </font></td></table></b>";
			echo "<p></p>";
			echo "<a href='javascript:window.close();'>Cerrar Ventana</a>";
		}

	}

	//De lo contrario validación de extension no aprobada. 
	else{
		//de lo contrario, si archivo fue denegado para upload.. pero no presenta error al subir un archivo
		if($_FILES['uploadedfile']['error']==0){
			echo "Formato de archivo no aceptado! (<b>".$ext_fname."</b>). Solo se permite <b>(.txt)</b><p></p>";
		}
		if ($_FILES['uploadedfile']['error'] > 0){
			echo "<body bgcolor='#666666' link='#CCCCCC' alink='#99FF66' vlink='#FFFFFF'>";
			echo("<font color='white' size='6'> Error:" . $_FILES["uploadedfile"]["error"] . "</font><br />");
			echo ("<p></p>");
          		switch ($_FILES['uploadedfile']['error']){
					case 1: // UPLOAD_ERR_INI_SIZE
						echo "<body bgcolor='#666666' link='#CCCCCC' alink='#99FF66' vlink='#FFFFFF'>";
                   		echo "<font color='white' size='5'> El archivo sobrepasa el limite autorizado por el servidor(archivo php.ini)! </font>";
						echo "<p></p>";
					break;
                   	case 2: // UPLOAD_ERR_FORM_SIZE
						echo "<body bgcolor='#666666' link='#CCCCCC' alink='#99FF66' vlink='#FFFFFF'>";
                   		echo "<font color='white' size='5'>El archivo sobrepasa el limite autorizado en el formulario index.php (MAX_FILE_SIZE) ! </font>";
                  		echo "<p></p>";
					break;
                   	case 3: // UPLOAD_ERR_PARTIAL
						echo "<body bgcolor='#666666' link='#CCCCCC' alink='#99FF66' vlink='#FFFFFF'>";
                  		echo "<font color='white' size='5'>El envio del archivo ha sido suspendido durante la transferencia! </font>";
                   		echo "<p></p>";
					break;
                   	case 4: // UPLOAD_ERR_NO_FILE
						echo "<body bgcolor='#666666' link='#CCCCCC' alink='#99FF66' vlink='#FFFFFF'>";
                  		echo "<font color='white' size='5'>El archivo que ha enviado tiene un tamaño nulo! (archivo inv&aacute;lido) </font>";
                 		echo "<p></p>";
					break;
				}
		}

	echo "<a href='javascript:window.close()'>Cerrar Ventana</a>";
	}

}

echo "</center></body>"; 
?><link rel="stylesheet" type="text/css" href="../libs/DWStyle.css" />