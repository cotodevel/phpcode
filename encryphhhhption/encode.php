<?php
include 'encdec20.php';
$pass=trim($_POST["pass"]);
$encrypted=encrypt($pass);
?>
<html>
<body>
<b>Encrypted Word Area</b><p></p>
Your encrypted word is:
<input type="text" value="<?php echo $encrypted["encoded"]; ?>"><p></p>
And your password to decrypt the word is:
<input type="text" value="<?php echo $encrypted["password"]; ?>"><p></p>
-----------------------------------------------------------------------------------------
<p></p>
<b>Decryption Word Area</b>
<p></p>Now, please fill in the following text boxes to decrypt the content you've encrypted.
<p></p>
<form action="decode.php" method="post">
Encrypted word:&nbsp;
<input type="text" name="encrypted" value="<?php echo $encrypted["encoded"]; ?>">
<p></p>
Password:&nbsp;
<input type="text" name="password" value="<?php echo $encrypted["password"]; ?>">
<input type="hidden" name="hid_w_del" value="<?php echo $encrypted["w_del"]; ?>">
<p></p>
<input type="submit" value="Decrypt Dataw!">
</form>
</body>
</html>