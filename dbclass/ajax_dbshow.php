<html>
<head>
<script>
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=760,height=532');");
}
</script>
</head>
<?php
header("refresh:10 ajax_dbshow.php");
include 'class.php';
//dibujamos BD usando datos en memoria $_SESSION data_main
if(isset($_SESSION['data_main'])) db_show($_SESSION['data_main']);
else db_show('1'); 
?>