<?php
include '../class.php';

$getval=($_GET['val']);

//gui de agregar nueva base de datos
if ($getval=="addnewbd") header("location: add_data/index.php");

//gui de modificar base de datos existente
else if($getval=="modifexisbd") echo "modificar bd existente!";

//gui de eliminar base de datos existente
else if($getval=="delexisbd") echo "eliminar bd existente!";

//gui de importar datos al sistema!
else if($getval=="importdata")
{
?>

<!-- gui de subir archivos -->
<html>
<script language="JavaScript">
function vacio(q) { 
for ( i = 0; i < q.length; i++ ) {
 if ( q.charAt(i) != " " ) {
  return true
  } 
  }  
         return false  
}  
   
 //valida que el campo no este vacio y no tenga solo espacios en blanco  
 function valida(F) {  
           
         if( vacio(F.txt_user.value && F.txt_pass.value && F.txt_pass2.value && F.txt_mail.value ) == false )
		 {  
                 alert("Mientras un campo estée en blanco, no podrá continuar.")  
                 return false  
         } 
		 
		 else if (F.txt_pass.value != F.txt_pass2.value)
		 { 
		 	alert("Los campos de contraseña no coinciden");
		 	return false
		 }
			
		 else
		 
		 return true 
		 
         }  
</script>

<body bgcolor="#666666" link="#CCCCCC" alink="#99FF66" vlink="#FFFFFF">
<center>
<form enctype="multipart/form-data" action="./upload.php" onSubmit="return valida(this);" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="2048000"//EnBYTES y aca define el tamaño limite de subida />
<font color="#FFFFCC">Adjunte un archivo:
<p></p> El archivo no debera superar los (2MB) </u>.</font><p>
</p> <input name="uploadedfile" type="file" /><br/>
<input type="submit" value="Adjunta Archivo!" />
<p></p>
<p></p>
<p></p>
<a href='javascript:window.close();'><strong>Salir</strong> </a>
</form>
</center>
</html>


<?php
}
//gui de exportar datos completos!
else if($getval=="exportdata")
{
exp_data($_SESSION['data_main']);
//fin exportar db
}

//guardar datos en .txt permanentemente
//gui de importar datos al sistema!
else if($getval=="savedata")
{
save_data($_SESSION['data_main']);
}

//reconstruir una DB con el formato correcto
else if($getval=="builddb")
{
build_db("ds_dbid:null00-00null00-00tkey:null00-00null00-00dbfid:null00-00null00-00pk0ai0-+//+-rs_fid:null00-00Bereta00-00fval:pk1ai0",0);
}
//destruir dato fisico de DB en servidor
else if($getval=="destroydata")
{
destroy_data($_SESSION['data_main']);
//fin destruye db en servidor ftp
}
?>