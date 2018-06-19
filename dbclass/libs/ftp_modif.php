<?php
//init session code
if(!defined($_SESSION['ftp_disabled'])){
	session_start();
	$_SESSION['ftp_disabled']=0;
}

//Usuario FTP
$usuario_total='b16_14032172';	
//Contraseña FTP
$contras_total='test1234';
//Ruta destino a conectar
$ruta_ftp='ftp.byethost16.com';
//Directorio destino de ruta
$dir_remota='/htdocs';
//directorio http
$ruta_http=strtolower("www".substr($ruta_ftp,3));
//ruta destino a guardar la db
$filedr="/dbclass/db/";
//nombre db
$db_nm="db.txt";

//only once if havent connected yet, otherwise will re-connect if success
if ($_SESSION['ftp_disabled']==0){
	// Primero creamos un ID de conexión a nuestro servidor
	$cid=ftp_connect($ruta_ftp);
	
	// Luego creamos un login al mismo con nuestro usuario y contraseña
	$resultado=ftp_login($cid, $usuario_total ,$contras_total);
		
	// Comprobamos que se creo el Id de conexión y se pudo hacer el login
	if ( (!$cid) || (!$resultado) ){
		//Disabled because we use header output for files (and this msg is embedded as well)
		//echo "FAILED TO CONNECT. GOING: <p></p>";
		//echo "<font color='green'><b>LOCAL</b></font>";
		$_SESSION['ftp_disabled']=1;
	}
	else{
		ftp_pasv ($cid, true);
		echo "<font color='green'><b>FTP</b></font>";
		$_SESSION['ftp_disabled']=0;
	}
}

//else definitely offline & already tried to FTP login
else{
echo "offline & ftp connect failed";
}

?>