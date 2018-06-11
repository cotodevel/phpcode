<?php
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

// Primero creamos un ID de conexión a nuestro servidor
$cid=ftp_connect($ruta_ftp);
// Luego creamos un login al mismo con nuestro usuario y contraseña
$resultado=ftp_login($cid, $usuario_total ,$contras_total);
// Comprobamos que se creo el Id de conexión y se pudo hacer el login
if ((!$cid) || (!$resultado)){
echo "<font color='green'><b>LOCAL</b></font>";
}
else{
//continua programa
ftp_pasv ($cid, true);
echo "<font color='green'><b>FTP</b></font>";
}

?>