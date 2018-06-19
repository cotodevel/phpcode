<?php
session_start();
//diccionario y pw para encriptar/desencriptar.
//diccionario es obligatorio o programa no funcionaw.
//diccionario necesario para encripcion
if ((@include "diccionario.php") != '1')
	{
	echo "<center>error al incluir una libreria necesaria para el programa. (diccionario.php) <p></p>";
	echo "<a href='Javascript:window.close();'>Cerrar Ventana</a></center>";
	echo getcwd();
	exit();
	}
//fin diccionario
//flag que determina reporte de error.
//0 retorna falso, 1 retorna detalles de error
$flag_fail=1;

//genera azar hasta 1.400.000 indices!!!!!
function col_new($num)
{
//funcion range entrega numeros int desde,hasta
$num=range(1,$num);
shuffle($num);
return $num;
}

//encripta palabras usando sorteo al azar de palabras de un diccionario
//necesita: string a encriptar
//retorna:
//array
//  'encoded' => string 'd3J1anI5amMzdGZhZnczZnltMmU5MnJ5OTI1dHV3cXVoM3I3NGhyMXdkYTllYjl5NWg0YTc5bXIxcjFhYmJkNmg3cmZycWk0ZW5hdysyZHJ0NTJ0eXdyYTFhcXkyZTh0MnQyMXMxOGVlNXI1ZmQ=FFNklYDGNGT2Ym5JZ==MQOVQ24' (length=174)
//  'password' => string 'Y2JlNGQ5ZTk4NGY2ODVmMQ==' (length=24)
function encrypt($main_pass)
{
global $flag_fail;
global $dic;
$res=NULL;

//diccionario valido (para word), se puede cambiar desde sesion, con rand(), etc
//hay que generar diccionarios para luego ser cargados por otras funciones
	if (!isset($main_pass))
		{
			//check $flag_fail. 0=false 1=genera error reporting
			if ($flag_fail==0)
			{
			return false;
			}
			else if ($flag_fail==1)
			{
			$pw_built=array("string_enc"=>"??????","pw_status"=>"Error:encrypt(); No ingresaste la palabra a encriptar.");
			return $pw_built;
			}
		}
			//formula para encriptar pass
			$cnt_pass=strlen($main_pass);
			//cuenta palabras del diccionario
			$ndic=count($dic);
			if ($ndic==FALSE||$ndic==NULL||$ndic==0)
			{
				echo "<center><b>Error Grave, diccionario no fu&eacute;e inclu&iacute;do. encrypt();</b></center>";
				exit();
			}
			//sorteamos cant de numeros al azar basado en pw
			//nota: $cont genera palabras al azar basado en $ndic, por lo que $azar ha de generar valores dentro del rango de $ndic
			//ademas de estar en el rango de cantidad de palabras generadas
			$cnt_pass=strlen($main_pass);
			$azar=col_new($ndic+$cnt_pass);
			//generamos $basura en $contenedor de acuerdo a $ndic*100
			for($i=0;$i<$ndic+$cnt_pass;$i++)
				{
				//garbage. pos azar de word de diccionario se escribe en cont
				$cont[]=$dic[rand(0,$ndic-1)];
				}
				//fin for cuenta diccionario
			//valida col
			//recorremos password basado cantidad de caracteres del mismo
			
			for($pass=0;$pass<$cnt_pass;$pass++)
			{
				$ssap_w=substr($main_pass,-1-$pass,1);
				//guardamos word de pw em $contenedor con pos $pass de $azar (azar) y generamos un indice
				//nota: $cont genera palabras al azar basado en $ndic, por lo que $azar ha de generar valoresdentro del rango de $ndic
				$cont[$azar[$pass]]=$ssap_w;
				$indice[]=$azar[$pass];
			}//fin validacol
//$cont es contenedor con pajar de palabras		
$words=implode("",$cont);
//a base 64 encode el pajar de palabras
$words=base64_encode($words);
//con esto se cual es la longitud de la palabra encriptada
$cnt_words=strlen($words);
//cuenta indices en array
$cnt_ind=count($indice);
for($i=0;$i<$cnt_ind;$i++)
{ 
//delimiter==g$ndic
$res=$res.dechex($indice[$i]+$ndic)."g$ndic".dechex(rand(10,15)); 
}

$b64encind_ori=base64_encode($res);
//shuffle($b64encind);
//reordenamos llaves de array
//ksort($b64encind);
for($i=0;$i<strlen($b64encind_ori);$i++)
{
$shuff_ind[]=$b64encind_ori[$i];
}
shuffle($shuff_ind);
$shuff_ind=implode("",$shuff_ind);
$ncoded=$words.$shuff_ind;
$w_del=strlen($words);

$encoded=array("encoded"=>$ncoded,"password"=>$b64encind_ori,"w_del"=>$w_del);
unset($cont,$ncoded,$w_del,$indice,$shuff_ind,$b64encind_ori,$res,$dic,$cnt_ind,$main_pass,$ssap_w,$string,$azar,$ndic,$cnt_pass);
return $encoded;
}
//decrypt: basado en el diccionario que posea el sistema, realiza verificacion de llave entregada separadamente
//de llave incrustada en $string encriptado
//necesita: encrypted(encoded,key) para desencriptar
function decrypt($string,$key,$w_del)
{
global $dic;
global $flag_fail;
global $keyw;

if(!isset($string)||!isset($key)||!isset($w_del))
{
		//si $string o llave, error.
		//check $flag_fail. 0=false 1=genera error reporting
		if ($flag_fail==0)
		{
		return false;
		}
		else if ($flag_fail==1)
		{
		$pw_dec=array("string_enc"=>$string,"pw_status"=>"BAD:decrypt(); Null or blank key","key_ori"=>$key,"key_enc"=>"null","decrypted"=>"Yuck");
		return $pw_dec;
		}
}
$key_ori=$key;
//formula para encriptar pass
$cnt_pass=strlen($string);
//cuenta palabras del diccionario
$ndic=count($dic);
if ($ndic==FALSE||$ndic==NULL||$ndic==0)
	{
	echo "<center><b>Error Grave, diccionario no fu&eacute;e inclu&iacute;do. decrypt();</b></center>";
	exit();
	}
//desencripta
//retiramos $encoded de $string, nos entrega llave sorted y la comparamos con $key
$s_key=substr($string,$w_del);
//revisa algoritmo
$cnt_key=strlen($key);
$cnt_skey=strlen($s_key);
for($i=0;$i<$cnt_key;$i++)
{
	for($j=0;$j<$cnt_skey;$j++)
	{
		if ($key[$i]==$s_key[$j])
		{
		//guardamos $key original en memoria
		$match[]=$key[$i];
		$j=$cnt_skey;
		}
	//cerramos ciclo
	}
//termina thread y busca $key de pos siguiente
}
$cnt_match=count($match);
if ((count($match)!=$cnt_key)||(count($match)!=$cnt_skey))
{
//moo
		//si $key no coincide con $new_key, error.
		//check $flag_fail. 0=false 1=genera error reporting
		if ($flag_fail==0)
		{
		return false;
		}
		else if ($flag_fail==1)
		{
		$pw_dec=array("string_enc"=>$string,"pw_status"=>"BAD:decrypt(); password mismatch, sorry.","key_ori"=>$key,"key_gen"=>$s_key,"decrypted"=>"Yuck");
		return $pw_dec;
		}
}
/////////////////////////////////////////fin check1/////////////////////////////////////////////
//2nd check
if (strstr("=".$s_key,$key)==TRUE)
{
//moo
		//si $key es el $key generado al final del archivo, error.
		if ($flag_fail==0)
		{
		return false;
		}
		else if ($flag_fail==1)
		{
		$pw_dec=array("string_enc"=>$string,"pw_status"=>"BAD:decrypt(); password mismatch, sorry.","key_ori"=>$key,"key_gen"=>$s_key,"decrypted"=>"Yuck");
		return $pw_dec;
		}
}
//fin 2nd check
////////////////////////////////////////////////////////DECRYPT INDICE///////////////////////////////////////////////////////////
//realizamos base64_decode a $key (pass encriptada)
$b64decind=base64_decode($key);
$totchar=strlen($b64decind);
//revisa cada pos de clave
for($i=0;$i<$totchar;$i++)
{
	//revisa y encapsula cada clave (separada por delimiter)
	$ind=substr($b64decind,$i,strlen("g$ndic"));
	$chword=substr($b64decind,$i,1);
	//si indice es delimiter g$ndic, se crea contenedor nuevo
	//y llave a 0
	if ($ind=="g$ndic")
	{
	$cont[]=$keyw;
	$keyw="";
	}
	//$word unitaria se almacena en $key concatenada y se le retira
	//g$ndic
	$keyw.=$chword;
	$keyw=str_replace("g$ndic".$chword,"",$keyw);
}
//segundo thread, depura los indices 
for($i=0;$i<count($cont);$i++)
{
$ind=hexdec($cont[$i]);
$i_dec[]=$ind-$ndic;
}
////////////////////////////////////////////////////FIN DECRYPT INDICE////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////DECRYPT $WORD ENCRYPTED///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//str_replace($aguja,$reemplazadora,$search) quitamos llave y desencriptamos con esa misma
$cnt_string_wrd=strlen($string)-strlen($key_ori);
$string_sinpw=substr($string,0,$cnt_string_wrd);
//quitarle base64encode. aca recibo string SIN password
$string_enc=base64_decode($string_sinpw);
//finalmente usamos $i_dec y buscamos el valor del array individual de indice, y retiramos esa palabra de $strinc_enc
for($i=0;$i<count($i_dec);$i++)
{
//ahora basado en n string, pick up the word y paste
	$w=substr($string_enc,$i_dec[$i],1);
	$pw_built[1-$i]=$w;
}
//reordenamos array de $pw
ksort($pw_built);
//concatenamos y entregamos pass finalmente.
$pw_built=implode("",$pw_built);
//datos de error para tener mas detalles.
$pw_dec=array("string_enc"=>$string,"pw_status"=>"OK","key_ori"=>$key,"decrypted"=>$pw_built);
unset($key,$b64decind,$totchar,$i,$ind,$chword,$cont,$keyw,$key_ori,$i_dec,$string_sinpw,$string,$string_enc,$pw_built);
return $pw_dec;
}
?>