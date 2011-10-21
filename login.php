<body>
<?php
include "includes/header.php";
if($getid == "error")  
{  
  echo "<div id='Index'><p>Die Zugangsdaten waren ungültig.</p></div>";  
}
echo "<title>Login - $sitename</title>";
echo '<div id="Index"><p><form action="" method="post">  
Benutzername:<br><input type="text" name="id" size="20"><br>
Passwort:<br><input type="password" name="pwd" size="20"><br>
<select name="cookietime">
<option value="1">1 Tag</option>
<option value="7">1 Woche</option>
<option value="30">1 Monat</option>
<option value="365">1 Jahr</option>
</select><br>
<input type="submit" value="Login" name="postlogin">  
</form></p></div>'; 
if(isset($_POST['postlogin'])) {

$mysql->query("SELECT id, username, password FROM accounts WHERE username = '".$_POST['id']."' AND password = '".sha1($_POST['pwd'])."' AND active = '1'");  

if (mysql_num_rows($mysql->result) > 0)  
{
$data = mysql_fetch_array ($mysql->result);  
$mysql->query("Select admin from accounts WHERE username = '".$_POST['id']."' AND admin = '1'");
$rows = mysql_num_rows($mysql->result);
if($rows == 1) { 
  setcookie($cp."_admin_id", $data['id'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  setcookie($cp."_admin_name", $data['username'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  setcookie($cp."_user_id", $data['id'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  setcookie($cp."_user_name", $data['username'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  $mysql->query("UPDATE accounts SET remote_addr = '".$_SERVER['REMOTE_ADDR']."' WHERE username = '".$data['username']."'");
echo '<meta http-equiv="refresh" content="0; url=admin.php">';
}
elseif($rows == 0) {
  setcookie($cp."_user_id", $data['id'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  setcookie($cp."_user_name", $data['username'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  $mysql->query("UPDATE accounts SET remote_addr = '".$_SERVER['REMOTE_ADDR']."' WHERE username = '".$data['username']."'");
echo '<meta http-equiv="refresh" content="0; url=index.php">';
}
}
else {
echo '<meta http-equiv="refresh" content="0; url=login.phpID=error">';
}
}
if($getid == "logout") { 
  setcookie($cp."_admin_id", "", time()-60*60*24*365, $path, $domain);
  setcookie($cp."_admin_name", "", time()-60*60*24*365, $path, $domain);
  setcookie($cp."_user_id", "", time()-60*60*24*365, $path, $domain);
  setcookie($cp."_user_name", "", time()-60*60*24*365, $path, $domain);
echo '<meta http-equiv="refresh" content="0; url=index.php">';
}
?>
</body>