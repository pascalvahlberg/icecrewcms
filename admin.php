<body><?phpinclude "includes/admin.php";include "includes/menu.php";include "includes/header.php";echo "$menu_admin";$getposts = $_GET['posts'];$getnews = $_GET['news'];$getusers = $_GET['users'];$getsettings = $_GET['settings'];$getdownloads = $_GET['downloads'];$getforum = $_GET['forum'];if(empty($getposts) and empty($getusers) and empty($getnews) and empty($getsettings) and empty($getdownloads) and empty($getforwarding) and empty($getid) and empty($getforum)) {echo "<title>Adminpanel - $sitename</title>";echo '<div id="Admin">Bitte w�hle eine Funktion</div>';}if($getposts == 'create') {echo "<title>Beitrag erstellen - $sitename</title>";echo '<div id="Admin"><form action="" method="post">Titel: <input type="text" name="name" size="50" maxlength="50"><br><textarea type="text" name="text" style="width:100%; height:275"></textarea><input type="submit" name="pcreate" value="Ver�ffentlichen"><form></div>';}if(isset($_POST['name'])) {$name = $_POST['name'];$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);$text = str_replace('href="', 'href="redirect.php?ID=', $pretext);if(empty($name)) {echo '<meta http-equiv="refresh" content="0; url=?ID=error">';}else {$mysql->query("INSERT INTO posts (name, text, username) VALUES ('".$name."', '".$text."', '".$_COOKIE[$cp.'_admin_name']."')");echo '<meta http-equiv="refresh" content="0; url=?ID=success">';}}if($getposts == 'delete') {echo "<title>Beitrag l�schen - $sitename</title>";$mysql->query("select id,name,username from posts");echo "<div id='Admin'>";while($sql = mysql_fetch_array($mysql->result)) {echo '<form action="" method="post"><input type="submit" value="'.$sql["name"].' von '.$sql["username"].' l�schen" name="'.$sql["id"].'"></form>';if(isset($_POST[$sql['id']])) {$mysql->query("DELETE FROM posts WHERE id = '".$sql['id']."'");echo '<meta http-equiv="refresh" content="0; url=?ID=success">';}}echo "</div>";}if($getid == "success") {echo "<title>Erfolgreich - $sitename</title>";echo '<div id="Admin">Aktion erfolgreich ausgef�hrt!<br><a href="admin.php">Weiter</a><meta http-equiv="refresh" content="3; url=admin.php"></div>';}if($getid == "error") {echo "<title>Fehler - $sitename</title>";echo "<div id='Admin'>Dir ist ein Fehler unterlaufen!<br><input type=\"button\" value=\"Zur�ck\" onclick=\"history.back(-1)\"></div>";}if($getusers == 'delete') {echo "<title>Benutzer l�schen - $sitename</title>";$mysql->query("select id,username from accounts WHERE safe = '0' and active = '1'");echo "<div id='Admin'><p><b><u>Aktiv:</u></b><br>";while($sql = mysql_fetch_array($mysql->result)) {echo '<a href="?users=delete&ID='.$sql["id"].'" id="N">'.$sql["username"].'</a>';}echo "</p>";$mysql->query("select id,username from accounts WHERE safe = '0' and active = '0'");echo "<p><b><u>Inaktiv:</u></b><br>";while($sql = mysql_fetch_array($mysql->result)) {echo '<a href="?users=delete&ID='.$sql["id"].'" id="N">'.$sql["username"].'</a>';}echo "</p>";echo "</div>";if($getusers == "delete" and isset($getid)) {$mysql->query("DELETE FROM accounts WHERE id = '$getid' and safe = '0'");echo '<meta http-equiv="refresh" content="0; url=?ID=success">';}echo "</div>";}if($getusers == 'list') {echo "<title>Benutzerliste - $sitename</title>";echo "<div id='Admin'><b><u>Administratoren:</u></b><br>";$mysql->query("select username from accounts where admin = '1'");while($sqladmin = mysql_fetch_array($mysql->result)) {echo $sqladmin['username']."<br>";}echo "</div>";echo "<div id='Admin'><b><u>Benutzer (aktiv):</u></b><br>";$mysql->query("select username from accounts where admin = '0' AND active = '1'");while($sql = mysql_fetch_array($mysql->result)) {echo $sql['username']."<br>";}echo "</div>";echo "<div id='Admin'><b><u>Benutzer (inaktiv):</u></b><br>";$mysql->query("select username from accounts where admin = '0' AND active = '0'");while($sql = mysql_fetch_array($mysql->result)) {echo $sql['username']."<br>";}echo "</div>";}if($getusers == 'manage') {echo "<title>Benutzerverwaltung - $sitename</title>";$mysql->query("select id,username from accounts WHERE admin = '1' AND safe = '0' and active = '1'");echo "<div id='Admin'>";while($sql = mysql_fetch_array($mysql->result)) {echo '<form action="" method="post"><input type="submit" value="'.$sql["username"].' zum Benutzer degradieren" name="unset'.$sql["id"].'"></form>';if(isset($_POST["unset".$sql['id']])) {$mysql->query("UPDATE accounts SET admin = '0' WHERE id = '".$sql['id']."'");echo '<meta http-equiv="refresh" content="0; url=?ID=success">';}}echo "</div>";$mysql->query("select id,username from accounts WHERE admin = '0' and active = '1'");echo "<div id='Admin'>";while($sql = mysql_fetch_array($mysql->result)) {echo '<form action="" method="post"><input type="submit" value="'.$sql["username"].' zum Admin bef�rdern" name="set'.$sql["id"].'"></form>';if(isset($_POST["set".$sql['id']])) {$mysql->query("UPDATE accounts SET admin = '1' WHERE id = '".$sql['id']."'");echo '<meta http-equiv="refresh" content="0; url=?ID=success">';}}echo "</div>";}if($getnews == 'create') {echo "<title>News erstellen - $sitename</title>";echo '<div id="Admin"><form action="" method="post">Titel: <input type="text" name="newsname" size="50" maxlength="50"><br><textarea type="text" name="text" style="width:100%; height:275"></textarea><input type="submit" name="ncreate" value="Ver�ffentlichen"><form></div>';}if(isset($_POST['newsname'])) {$name = $_POST['newsname'];$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);$text = str_replace('href="', 'href="redirect.php?ID=', $pretext);if(empty($name)) {echo '<meta http-equiv="refresh" content="0, url=?ID=error">';}else {$mysql->query("INSERT INTO news (name, text, username) VALUES ('".$name."', '".$text."', '".$_COOKIE[$cp.'_admin_name']."')");echo '<meta http-equiv="refresh" content="0; url=?ID=success">';}}if($getnews == 'delete') {echo "<title>News l�schen - $sitename</title>";$mysql->query("select id,name,username from news");echo "<div id='Admin'>";while($sql = mysql_fetch_array($mysql->result)) {echo '<form action="" method="post"><input type="submit" value="'.$sql["name"].' von '.$sql["username"].' l�schen" name="'.$sql['id'].'"></form>';if(isset($_POST[$sql['id']])) {$mysql->query("DELETE FROM news WHERE id = '".$sql['id']."'");echo '<meta http-equiv="refresh" content="0; url=?ID=success">';}}echo "</div>";}if($getsettings == "cms") {$email = $impressum_email;echo "<title>Einstellungen - $sitename</title>";echo '<div id="Admin"><form action="" method="post">';if($gastkommentar == 1) {echo 'Gast Kommentare: <select name="gastkommentar"><option value="1">Erlauben</option><option value="0">Verbieten</option></select><br>';}else {echo 'Gast Kommentare: <select name="gastkommentar"><option value="0">Verbieten</option><option value="1">Erlauben</option></select><br>';}echo '<h3>Server-Konfiguration:</h3>Seitenname:<br><input type="text" name="sitename" value="'.$sitename.'" maxlength="25"><br>Datenbank-Host:<br><input type="text" name="dbhost" value="'.$dbhost.'" maxlength="50"><br>Datenbank-Name:<br><input type="text" name="dbname" value="'.$dbname.'" maxlength="25"><br>Datenbank-Benutzer:<br><input type="text" name="dbuser" value="'.$dbuser.'" maxlength="25"><br>Datenbank-Passwort:<br><input type="password" name="dbpasswd" value="'.$dbpasswd.'" maxlength="50"><br>Cookie-Pr�fix:<br><input type="text" name="cp" value="'.$cp.'" maxlength="10"><h3>Impressum-Konfiguration (optional)</h3>Name:<br><input type="text" name="impressum_name" value="'.$impressum_name.'" maxlength="50"><br>Land:<br><input type="text" name="impressum_land" value="'.$impressum_land.'" maxlength="50"><br>Postleitzahl:<br><input type="text" name="impressum_postleitzahl" value="'.$impressum_postleitzahl.'" maxlength="50"><br>Stadt:<br><input type="text" name="impressum_stadt" value="'.$impressum_stadt.'" maxlength="50"><br>Stra�e:<br><input type="text" name="impressum_stra�e" value="'.$impressum_stra�e.'" maxlength="50"><br>Hausnummer:<br><input type="text" name="impressum_hausnummer" value="'.$impressum_hausnummer.'" maxlength="50"><br>E-Mail:<br><input type="text" name="impressum_email" value="'.$email.'" maxlength="50"><br>Telefon:<br><input type="text" name="impressum_telefon" value="'.$impressum_telefon.'" maxlength="50"><h3>CMS</h3>Template:<br><input type="text" name="template" value="'.$infos["template"].'"><br><input type="submit" name="cmssettingspost" value="Einstellungen �bernehmen"></form></div>';if(isset($_POST['sitename'])) {$email = $_POST['impressum_email'];$configfile = "includes/config.php";$write = "<?php\$sitename = \"".$_POST['sitename']."\";\$dbhost = \"".$_POST['dbhost']."\";\$dbuser = \"".$_POST['dbuser']."\";\$dbpasswd = \"".$_POST['dbpasswd']."\";\$dbname = \"".$_POST['dbname']."\";\$cp = \"".$_POST['cp']."\";//do not touch following//impress\$impressum_name = \"".$_POST['impressum_name']."\";\$impressum_land = \"".$_POST['impressum_land']."\";\$impressum_postleitzahl = \"".$_POST['impressum_postleitzahl']."\";\$impressum_stadt = \"".$_POST['impressum_stadt']."\";\$impressum_stra�e = \"".$_POST['impressum_stra�e']."\";\$impressum_hausnummer = \"".$_POST['impressum_hausnummer']."\";\$impressum_email = \"".$email."\";\$impressum_telefon = \"".$_POST['impressum_telefon']."\";//cms\$gastkommentar = \"".$_POST['gastkommentar']."\";?>";if (is_writable($configfile)) {    if (!$handle = fopen($configfile, "w+")) {         print "<div id='Admin'>Kann die Datei $configfile nicht �ffnen</div>";         exit;    }    if (!fwrite($handle, $write)) {        print "<div id='Admin'>Kann in die Datei $configfile nicht schreiben</div>";        exit;    }    print "<div id='Admin'>Konfiguration erfolgreich!</div>";    fclose($handle);	$mysql->query("UPDATE cms_info SET template = '".$_POST['template']."'");	$mysql->query("UPDATE cms_info SET path = '$path'");	echo '<meta http-equiv="refresh" content="0, url=?ID=success">';} else {    print "<div id='Admin'>Die Datei $configfile ist nicht schreibbar</div>";}}}if($getdownloads == 'create') {echo "<title>Download erstellen - $sitename</title>";echo '<div id="Admin"><form action="" method="post" enctype="multipart/form-data">Name: <input type="text" name="dlname" size="50"><br>Datei: <input type="file" name="datei" size="50"><br>Hochladen: <input type="submit" name="downloadaddpost" value="Best�tigen"></form></div>';if(isset($_POST['dlname'])) {$mysql->query("INSERT INTO downloads (name, filename, clicks) VALUES ('".$_POST['dlname']."', '".$_FILES['datei']['name']."', '0')");$mysql->query("SELECT * FROM downloads WHERE name = '".$_POST['dlname']."'");$dl = mysql_fetch_array($mysql->result);mkdir("downloads/".$dl['id'], 0777);move_uploaded_file($_FILES['datei']['tmp_name'], "downloads/".$dl['id']."/".$_FILES['datei']['name']);echo "<div id='Admin'>Datei hochgeladen</div>";}}if($getdownloads == 'delete') {echo "<title>Download l�schen - $sitename</title>";$mysql->query("select * from downloads");echo "<div id='Admin'>";while($sql = mysql_fetch_array($mysql->result)) {echo '<form action="" method="post"><input type="submit" value="'.$sql["name"].' ('.$sql["downloads"].' Downloads) l�schen" name="'.$sql["id"].'"></form>';if(isset($_POST[$sql['id']])) {$mysql->query("DELETE FROM downloads WHERE id = '".$sql['id']."'");unlink("downloads/".$sql['id']."/".$sql['filename']);rmdir("downloads/".$sql['id']);echo '<meta http-equiv="refresh" content="0; url=?ID=success">';}}echo "</div>";}if($getposts == "edit" and empty($getid)) {$mysql->query("select * from posts");echo "<title>Beitrag editieren - $sitename</title>";echo "<div id='Admin'>";while($sql = mysql_fetch_array($mysql->result)) {echo "<a href='?posts=edit&ID=".$sql['id']."'>\"".$sql['name']."\" editieren</a><br>";}echo "</div>";}if($getposts == "edit" and isset($getid)) {$mysql->query("select * from posts where id = '$getid'");while($sql = mysql_fetch_array($mysql->result)) {$text = str_replace("<br>", "", $sql['text']);echo "<title>".$sql['name']." editieren (Beitrag) - $sitename</title>";echo '<div id="Admin"><form action="" method="post">Titel: <input type="text" name="pname" size="50" maxlength="50" value="'.$sql["name"].'"><br><textarea type="text" name="text" style="width:100%; height:275">'.$text.'</textarea><br><input type="submit" name="pedit" value="Editieren"></form></div>';}}if(isset($_POST['pname'])) {echo "<title>".$_POST['pname']." editieren (Beitrag) - $sitename</title>";$text = str_replace("\r\n", "\r\n<br>", $_POST['text']);$mysql->query("UPDATE `posts` SET `name` = '".$_POST['pname']."' WHERE id = '$getid'");$mysql->query("UPDATE `posts` SET `text` = '$text' WHERE id = '$getid'");echo '<meta http-equiv="refresh" content="0, url=view.php?page=Posts&ID='.$getid.'">';}if($getnews == "edit" and empty($getid)) {$mysql->query("select * from news");echo "<title>News editieren - $sitename</title>";echo "<div id='Admin'>";while($sql = mysql_fetch_array($mysql->result)) {echo "<a href='?news=edit&ID=".$sql['id']."'>\"".$sql['name']."\" editieren</a><br>";}echo "</div>";}if($getnews == "edit" and isset($getid)) {$mysql->query("select * from news where id = '$getid'");while($sql = mysql_fetch_array($mysql->result)) {echo "<title>".$sql['name']." editieren (News) - $sitename</title>";$text = str_replace("<br>", "", $sql['text']);echo '<div id="Admin"><form action="" method="post">Titel: <input type="text" name="nname" size="50" maxlength="50" value="'.$sql["name"].'"><br><textarea type="text" name="text" style="width:100%; height:275">'.$text.'</textarea><br><input type="submit" name="nedit" value="Editieren"></form></div>';}}if(isset($_POST['nname'])) {echo "<title>".$_POST['nname']." editieren (News) - $sitename</title>";$text = str_replace("\r\n", "\r\n<br>", $_POST['text']);$mysql->query("UPDATE `news` SET `name` = '".$_POST['nname']."' WHERE id = '$getid'");$mysql->query("UPDATE `news` SET `text` = '$text' WHERE id = '$getid'");echo '<meta http-equiv="refresh" content="0, url=view.php?page=News&ID='.$getid.'">';}if($getforum == "create"){	echo "<title>Forum erstellen - $sitename</title>";	echo '<div id="Admin">	<form action="" method="post">	Name: <input type="text" name="fname" size="50" maxlength="50"> Position: <input type="text" name="fposition"><br>	<textarea type="text" name="text" style="width:100%; height:275"></textarea><br>	<input type="submit" name="fc" value="Erstellen">	</form>	</div>';	if(isset($_POST["fc"]))	{		$mysql->query("INSERT INTO forum_forums (name,description,position) VALUES ('".$_POST['fname']."', '".$_POST['text']."', '".$_POST['fposition']."')");		echo '<meta http-equiv="refresh" content="0; URL=?ID=success">';	}}if($getforum == "delete"){	echo '<title>Forum l�schen - '.$sitename.'</title>';	$mysql->query("SELECT * FROM forum_forums order by id");	echo '<div id="Admin">';	while($sql = mysql_fetch_array($mysql->result))	{		echo '<a href="?forum=delete&ID='.$sql["id"].'">"'.$sql["name"].'" l�schen</a><br>';	}}if($getforum == "delete" and isset($getid)){	$mysql->query("DELETE FROM forum_forums WHERE id = '$getid'");	$mysql->query("SELECT * FROM forum_threads WHERE forum = '$getid'");	while($dsql = mysql_fetch_array($mysql->result))	{		$mysql->query("DELETE FROM forum_threads WHERE forum = '$getid'");		$mysql->query("DELETE FROM forum_posts WHERE thread = '".$dsql['id']."'");	}	echo '<meta http-equiv="refresh" content="0; URL=?ID=success">';}?></body>