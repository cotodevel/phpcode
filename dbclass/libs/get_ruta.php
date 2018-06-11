<?php
//array
//  0 => 
//    array
//      'dir_num' => int 1
//      'ruta_dir_act' => string '\wamp\' (length=6)
//      'ruta_completa' => string 'C:\wamp\www\get_rutaact\' (length=24)
//  1 => 
//    array
//      'dir_num' => int 2
//      'ruta_dir_act' => string '\www\' (length=5)
//      'ruta_completa' => string 'C:\wamp\www\get_rutaact\' (length=24)
//  2 => 
//    array
//      'dir_num' => int 3
//      'ruta_dir_act' => string '\get_rutaact\' (length=13)
//      'ruta_completa' => string 'C:\wamp\www\get_rutaact\' (length=24)
//
//
//slashes a partir del dir local: 1
//uso: $output_dir = get_currentdir($dir_act);
chdir( dirname ( __FILE__ ) );
$slash = 0;
$ftp = false;
if ($ftp == true)
{
	if ((include './ftp_modif.php') != '1')
	{
	echo "<center>error al incluir una libreria necesaria para el programa.<p></p>";
	echo "<a href='Javascript:window.close();'>Cerrar Ventana</a></center>";
	exit();
	}
//ftp usa "/"	
$slash_flag = "/";
}
//local recorre con "\"
else
{
$slash_flag = "\\";
$ruta = "C:";
}
//usando getcwd(); o ftp_getcwd(); entrega las rutas de cada carpeta hija dependiendo del directorio que se le entrega. Devuelve array:

//get current working directory 
//$dir_act = getcwd().$slash_flag;

//retorna contenido del directorio actual
function get_dir_list()
{
$dir_act = getcwd().$slash_flag;
$manager_arch = opendir($dir_act);
while (false !== ($entrada = readdir($manager_arch))) {
        $folder[] = $entrada;
	}
return $folder;
}

//pedazo de codigo para determinar la ruta del area de trabajo
function get_currentdir()
{
global $slash;
global $ftp;
global $pos_ruta;
global $container;
global $slash_flag;
global $ruta;
$dir_act = getcwd().$slash_flag;

	//obtiene slashes
	$cnt_ruta = strlen($dir_act);
	$k = 0;
	
	//por cada caracter encontrado cuento los slashes
	for ($i = 0; $i < $cnt_ruta ; $i++)
		{
		//para posicion de vector 2d (guarda letra siguiente de frase $dir_act)
		$pos_ruta = substr($dir_act,$i,1);
		
		//si es FTP cuenta slash
			if ($ftp == TRUE)
			{
				//recolecta en $container mientras NO SEA backslash
					while ($dir_act[$i] != $slash_flag)
					{
					//la siguiente posicion seguido del backslash se guarda en $container hasta que se encuentre un nuevo backslash
					$container[] = $dir_act[$i];
					//break point
					$i++;
					}
					if ($dir_act[$i] == $slash_flag)
					{
					$container[] = $slash_flag;
					//por cada slash que exista en la ruta indicada, se agrega un contador de slash.
					$slash++;
					}
			}
		//si es local cuenta backslash
			else 
			{
					//recolecta en $container mientras NO SEA backslash
					while ($dir_act[$i] != $slash_flag)
					{
					//la siguiente posicion seguido del backslash se guarda en $container hasta que se encuentre un nuevo backslash
					$container[] = $dir_act[$i];
					//break point
					$i++;
					}
					if ($dir_act[$i] == $slash_flag)
					{
					$container[] = $slash_flag;
					//por cada slash que exista en la ruta indicada, se agrega un contador de slash.
					$slash++;
					}
			}
		//cada $container es un array que se sobreescribe sobre si mismo, luego copia variable a $lista 
		$list = $container;
		//end for
		}
//recolectamos $key como llave de array y $value como valor de array
foreach ($list as $key=>$value)
{
if ($value == $slash_flag)
{
//por cada "\" encontrado, guardamos la llave del array
$keys_arr[] = $key;
}
}
//contamos la cantidad de llaves de array encontradas ("\")
$cnt_keys = count($keys_arr);

//se resta 1 ya que "\" de la ultima carpeta no cuenta como ruta
$cnt_keys = $cnt_keys - 1;

//determinamos el límite de la longitud del array para restarlo contra el valor que deseamos obtener despues-
(int)$ult_pos = ($keys_arr[$cnt_keys-1]);

//recorremos la cantidad de llaves generadas por el array $keys_arr
//$num_ruta asigna un numero a la ruta actual (1 si es padre)
$num_ruta = 0;

for ($i=0;$i<$cnt_keys;$i++)
{
//valor del array (sincronizado en guardado de llave de array)
(int)$pos_word = ($keys_arr[$i]);
//si hay un value en array incrementado en uno (necesario para determinar la longitud de la palabra a buscar luego por substr)
if (isset($keys_arr[$i+1]))
{
(int)$long_word = ($keys_arr[$i+1]-$keys_arr[$i]);
}
//de lo contrario (al ser el ultimo value dentro del array $keys_arr, no se incrementa)
else
{
(int)$long_word = ($keys_arr[$i]-$keys_arr[$i]);
}
//se agrega 1 a la longitud de la palabra para obtener "\" al final de cada carpeta generada.
//(int)$long_word = $long_word + 1;
$dir_hijo = substr($dir_act,$pos_word,$long_word);

if ($i == 0)
{
$num_ruta = $num_ruta + 1;
$output_dir[] = array("dir_num" => $num_ruta, "ruta_dir_act" => $ruta.$slash_flag, "ruta_completa" => $dir_act);
}
$num_ruta = $num_ruta + 1;
$output_dir[] = array("dir_num" => $num_ruta, "ruta_dir_act" => $dir_hijo, "ruta_completa" => $dir_act);
}

//retorna directorios
//$output_dir = get_currentdir($dir_act);

//ruta base STAMARGARITA por FTP (6 slash para llegar al directorio base "/directorio_actual" )
if ($ftp == TRUE)
{
$slash = $slash - 6;
}
//de lo contrario ruta base STAMARGARITA por LOCAL (3 slash para llegar al directorio base "/directorio_actual" )
else
{
$slash = $slash - 3;
}

$cant_dir = count($output_dir);
//recorre cada directorio y muestra los archivos (hacia atras)
//preguntamos nivel de directorio. 1. el mas alto, $i el ultimo
for ($i = 0; $i < $cant_dir; $i++)
{
//posicion 0 (1 dentro de output_dir) indica ruta padre. entrega ruta padre, luego asigna a $ruta_actual ruta siguiente (hijo)
if ($i == 0)
{
$ruta_actual[] = $ruta.$slash_flag;
//echo "Para directorio padre: nivel:(".$output_dir[$i]['dir_num'].") <b>".$ruta_actual[$i]."</b><p></p>";
//var_dump(get_dir_list($ruta_actual[$i].$slash_flag));
//echo "---------------------------------------------------------<p></p>";
}
else
{
//se concatena a current_dir
//imprime ruta actual
$ruta_actual[] = $output_dir[$i]['ruta_dir_act'];
//si es la ultima posicion, se agrega $slash_flag
if ($i == $cant_dir - 1)
{
$ruta_actual[] = $slash_flag;
}
$current_dir = implode($ruta_actual);
//echo "Para directorio hijo: nivel:(".$output_dir[$i]['dir_num'].") <b>$current_dir</b>";
//var_dump(get_dir_list($current_dir));
//echo "<p></p>---------------------------------------------------------<p></p>";
//en caso que continuen mas rutas, se agrega un directorio mas a la ruta
//mientras hayan datos dentro de $output_dir[$i]['ruta_dir_act'] (directorio actual) se concatena.
}
}
return $current_dir;
}

?>