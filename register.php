<body>
<?php
include "includes/header.php";
if(empty($getid)) {
echo '<title>Registrierung - '.$sitename.'</title>
<div id="Index"><p><form action="" method="post">
Benutzername:<br><input type="text" name="username"><br>
Email-Addresse:<br><input type="text" name="email"><br>
Passwort:<br><input type="password" name="password"><br>
<input type="submit" name="register" value="Registrieren">
</form></p></div>';
if(isset($_POST['register']) AND !empty($_POST['email']) AND !empty($_POST['username']) AND !empty($_POST['password'])) {
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$sql = "Select username from accounts WHERE username = '".$user."'";
$mysql->query($sql);
$rows = mysql_num_rows($mysql->result);
if($rows == 1) {
echo "<div id='Index'><p>Der Benutzername wird bereits verwendet!</p></div>";
}
if($rows == 0) {
$mysql->query("INSERT INTO accounts (username, password, admin, safe, active, email) VALUES ('".$user."', '".$pw."', '0', '0', '0', '".$_POST['email']."')");
$mysql->query("SELECT id, username, password FROM accounts WHERE username = '".$user."' AND password = '".$pw."'");
$data = mysql_fetch_array($mysql->result);
$rows2 = mysql_num_rows($mysql->result);
if($rows2 == 1) { 
$mailto = $_POST['email'];
$mailsubject = "Ihr Account bei $sitename";
$mailmessage = "Hallo $user!
Wir freuen uns, dass du dich bei $sitename angemeldet hast.

Um deinen Account zu aktivieren, klicke bitte auf folgenden Link: http://".$domain.$path."activate.php?ID=".$data['id']."
Wenn der Link nicht funktioniert, versuche es bitte später nocheinmal. Oder wende dich an $impressum_email.

Accountdaten:

Benutzername: $user
Passwort: ".$_POST['password']."

Dein $sitename-Team.
--------------------------------------------------
Dies ist eine automatisch generierte Email. Bitte antworten sie nicht darauf.";
mail($mailto, $mailsubject, $mailmessage);
echo "<div id='Index'><p>Der User wurde erstellt. Es wurde eine Bestätigungsemail zum überprüfen der Gültigkeit der angegebenen Email-Addresse geschickt.</p></div>";
}
}
}
}
?>
</body>