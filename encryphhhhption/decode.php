<?php
include 'encdec20.php';
$encw=trim($_POST["encrypted"]);
$encpw=trim($_POST["password"]);
$w_del=trim($_POST["hid_w_del"]);
$decrypted=decrypt($encw,$encpw,$w_del);
?>
<html>
<body>
<b>Decryption:</b>
<p></p>
Encrypted word:<p></p>
<?php echo "<font color='red'><b>".$decrypted["string_enc"]."</b></font>"; ?>
<p></p>
Password decrypt status:<p></p>
<?php echo "<font color='red'><b>".$decrypted["pw_status"]."</b></font>"; ?>
<p></p>
------<p></p>
Original Key filled:<p></p>
<?php echo "<font color='red'><b>".$decrypted["key_ori"]."</b></font>"; ?>
<p></p>
------<p></p>
And finally, your decrypted ward:
<?php echo "<font color='red'><b>".$decrypted["decrypted"]."</b></font>"; ?>
------

If decrypted ward is <b>Yuck</b> then success isn't near.<p></p>
<?php $fun=strtolower($decrypted["decrypted"]); 
if ($fun=="yuck")
{
echo "<p></p>";
echo "<img src='http://i46.tinypic.com/1zyy906.png'></img>";
}
?>
</body>
</html>