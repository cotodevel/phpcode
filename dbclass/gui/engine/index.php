<?php
include '../../class.php';
$temp=(decrypt_db($_SESSION["data_main"]));
$data=cache_regstr($temp);
echo "<font color='red'><b>Stored Register Data:</b></font><p></p>";
var_dump($data);
$data=null;
echo "<p></p><b>***************************************</b></p>";
$data=cache_dbstr($temp);
echo "<font color='red'><b>Stored Structure Data</b></font>";
var_dump($data);

?>