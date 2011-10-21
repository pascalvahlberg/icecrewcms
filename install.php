<?php
echo '<title>IceCrew CMS Installation</title>
<a href="http://icecrew.sytes.net/" target="_blank"><img src="images/templates/default/site/logo.png" frameborder="0" border="0"></img></a>';
echo "<head>
<link rel='STYLESHEET' type='text/CSS' href='images/templates/default/style.css'>
<link rel='SHORTCUT ICON' href='images/templates/default/favicon.ico'>
</head>";
$version = 9;
$path = str_replace("install.php", "", $_SERVER['SCRIPT_NAME']);
$pstep = $_GET["step"] - 1;
$nstep = $_GET["step"] + 1;
$menu = '<ul id="Navigation"><li><a href="?step='.$pstep.'" id="N">Zurück</a></li><li><a href="?step='.$nstep.'" id="N">Weiter</a></li></ul>';
if(empty($_GET)) {
if(file_exists("includes/config.php") AND file_exists("includes/config.php.new")) {
echo $menu.'<div id="Index">IceCrew CMS ist bereits installiert!<br>
Klicken sie auf weiter, um ein Upgrade zu machen.<br>
<a href="upgrade.php" id="N">Upgrade</a></div>';
die;
}
else {
echo '<ul id="Navigation"><li><a href="?step=1" id="N">Weiter</a></li></ul><div id="Index">Klicken sie auf weiter, um mit der Installation zu beginnen!</div>';
}
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
rename("includes/config.php.new", "includes/config.php");
mkdir("downloads", 0777);
echo '<ul id="Navigation"><li><a href="install.php" id="N">Zurück</a></li></ul><div id="Index">
<form action="?step=2" method="post">
<h3>Server-Konfiguration:</h3>
Seitenname: <input type="text" name="sitename" maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" maxlength="50"><br>
Cookie-Präfix: <input type="text" name="cp" maxlength="10">
<h3>Impressum-Konfiguration (optional)</h3>
Name: <input type="text" name="impressum_name" maxlength="50"><br>
Land: <input type="text" name="impressum_land" maxlength="50"><br>
Postleitzahl: <input type="text" name="impressum_postleitzahl" maxlength="50"><br>
Stadt: <input type="text" name="impressum_stadt" maxlength="50"><br>
Straße: <input type="text" name="impressum_straße" maxlength="50"><br>
Hausnummer: <input type="text" name="impressum_hausnummer" maxlength="50"><br>
E-Mail: <input type="text" name="impressum_email" maxlength="50"><br>
Telefon: <input type="text" name="impressum_telefon" maxlength="50"><br>
<input type="submit" name="submit" value="Konfigurieren">
</form>
</div>';
}
if($_GET['step'] == 2) {
$email = $_POST['impressum_email'];
$configfile = "includes/config.php";
$write = "<?php
\$sitename = \"".$_POST['sitename']."\";
\$dbhost = \"".$_POST['dbhost']."\";
\$dbuser = \"".$_POST['dbuser']."\";
\$dbpasswd = \"".$_POST['dbpasswd']."\";
\$dbname = \"".$_POST['dbname']."\";
\$cp = \"".$_POST['cp']."\";
//do not touch following
//impress
\$impressum_name = \"".$_POST['impressum_name']."\";
\$impressum_land = \"".$_POST['impressum_land']."\";
\$impressum_postleitzahl = \"".$_POST['impressum_postleitzahl']."\";
\$impressum_stadt = \"".$_POST['impressum_stadt']."\";
\$impressum_straße = \"".$_POST['impressum_straße']."\";
\$impressum_hausnummer = \"".$_POST['impressum_hausnummer']."\";
\$impressum_email = \"".$email."\";
\$impressum_telefon = \"".$_POST['impressum_telefon']."\";
//cms
\$gastkommentar = \"0\";
?>";
if (is_writable($configfile)) {

    if (!$handle = fopen($configfile, "w+")) {
         print $menu."<div id='Index'>Kann die Datei $configfile nicht öffnen</div>";
         exit;
    }
    if (!fwrite($handle, $write)) {
        print $menu."<div id='Index'>Kann in die Datei $configfile nicht schreiben</div>";
        exit;
    }

    print $menu."<div id='Index'>Konfiguration erfolgreich!</div>";

    fclose($handle);
} else {
    print $menu."<div id='Index'>Die Datei $configfile ist nicht schreibbar</div>";
}
}
if($_GET['step'] == 3) {
include 'includes/config.php';
include_once "includes/class.mysql.php";
echo $menu.'<div id="Index">Tabelle: accounts... ';
$mysql->query("CREATE TABLE `accounts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `email` text COLLATE latin1_german1_ci NOT NULL,
  `password` text COLLATE latin1_german1_ci NOT NULL,
  `remote_addr` text COLLATE latin1_german1_ci NOT NULL,
  `admin` int(1) unsigned zerofill NOT NULL,
  `safe` int(1) unsigned zerofill NOT NULL,
  `active` int(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
echo 'erstellt!<br>Tabelle: posts... ';
$mysql->query("CREATE TABLE `posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  `views` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
echo 'erstellt!<br>Tabelle: news... ';
$mysql->query("CREATE TABLE `news` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  `views` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
echo 'erstellt!<br>Tabelle: downloads... ';
$mysql->query("CREATE TABLE `downloads` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `filename` text COLLATE latin1_german1_ci NOT NULL,
  `clicks` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
echo 'erstellt!<br>Tabelle: post_comments... ';
$mysql->query("CREATE TABLE `post_comments` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `msg` text COLLATE latin1_german1_ci NOT NULL,
  `position` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
echo 'erstellt!<br>Tabelle: news_comments... ';
$mysql->query("CREATE TABLE `news_comments` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `msg` text COLLATE latin1_german1_ci NOT NULL,
  `position` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
echo 'erstellt!<br>Tabelle: cms_info... ';
$mysql->query("CREATE TABLE `cms_info` (
  `version` int(100) NOT NULL,
  `template` text NOT NULL,
  `path` text NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
echo 'erstellt!<br>Tabelle: forum_forums... ';
$mysql->query("CREATE TABLE `forum_forums` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `description` text COLLATE latin1_german1_ci NOT NULL,
  `position` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
echo 'erstellt!<br>Tabelle: forum_threads... ';
$mysql->query("CREATE TABLE `forum_threads` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `forum` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
echo 'erstellt!<br>Tabelle: forum_posts... ';
$mysql->query("CREATE TABLE `forum_posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `thread` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("INSERT INTO `cms_info` (version, template, path) VALUES ('$version', 'default', '$path');");
echo 'erstellt!<br><br>Alle Tabellen wurden erfolgreich erstellt!</div>';
}
if($_GET['step'] == 4) {
echo $menu.'<div id="Index"><form action="?step=4" method="post">
Benutzername:<br><input type="text" name="username" maxlength="25"><br>
Passwort:<br><input type="password" name="password" maxlength="25"><br>
<input type="submit" name="submit" value="Admin Account erstellen">
</form></div>';
if(isset($_POST['password']) AND isset($_POST['username'])) {
include 'includes/config.php';
include_once "includes/class.mysql.php";
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$mysql->query("Select username from accounts WHERE username = '".$user."'");
$rows = @mysql_num_rows($mysql->result);
$mysql->query("INSERT INTO accounts (username, password, admin, safe, email, active) VALUES ('".$user."', '".$pw."', '1', '1', '$impressum_email', '1')");
$mysql->query("INSERT INTO news (username, name, text) VALUES ('".$user."', 'Glückwunsch!', 'Glückwunsch!<br>Du hast erfolgreich IceCrew CMS ".$version." installiert!<br>Du kannst diesen Newseintrag im Adminpanel löschen!<br><br>Mit freundlichen Grüßen, deine IceCrew')");
echo "<div id='Index'>Benutzer & News erfolgreich erstellt</div>";
}
}
}
if($_GET['step'] == 5) {
echo '<ul id="Navigation"><li><a href="?step=4" id="N">Zurück</a></li></ul><div id="Index">Installation erfolgreich beendet!
Um unsere Arbeit zu unterstützen, werben sie bitte für uns. Es ist nicht notwendig, wäre aber schön.
Helfen sie uns, bekannter zu werden.
<form action="index.php" method="post">
<input type="submit" name="installdeletefiles" value="Installations Dateien löschen">
</form></div>';
}
?>
</center>