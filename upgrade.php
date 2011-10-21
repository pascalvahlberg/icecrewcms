<title>IceCrew CMS Upgrade</title>
<?php
echo '<img src="images/templates/default/site/logo.png"></img><br>';
echo "<head>
<link rel='STYLESHEET' type='text/CSS' href='images/templates/default/style.css'>
<link rel='SHORTCUT ICON' href='images/templates/default/favicon.ico'>
</head>";
$version = 9;
$path = str_replace("upgrade.php", "", $_SERVER['SCRIPT_NAME']);
if(!file_exists("includes/config.php") AND file_exists("includes/config.php.new")) {
echo '<meta http-equiv="refresh" content="0; URL=install.php">';
die;
}
else {
@unlink('includes/config.php.new');
include 'includes/config.php';
include_once 'includes/class.mysql.php';
$mysql->query("SELECT version FROM cms_info");
$data = @mysql_fetch_array($mysql->result);
echo '<div id="Index">IceCrew CMS wird von '.$data["version"].' auf '.$version.' aktuallisiert.
<form action="" method="post">
<input type="submit" name="update" value="Updaten">
</form>';
if(isset($_POST["update"]))
{
	
	$pversion = $data['version'];
	if($pversion == 1)
	{
		$mysql->query("ALTER TABLE accounts ADD remote_addr text AFTER password");
$mysql->query("CREATE TABLE `forum_forums` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `description` text COLLATE latin1_german1_ci NOT NULL,
  `position` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("CREATE TABLE `forum_threads` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `forum` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("CREATE TABLE `forum_posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `thread` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
		$mysql->query("UPDATE cms_info SET version = $version");
		$mysql->query("ALTER TABLE cms_info ADD template text");
		$mysql->query("UPDATE cms_info SET template = 'default'");
		$mysql->query("ALTER TABLE cms_info ADD COLUMN path");
		$mysql->query("ALTER TABLE downloads CHANGE downloads clicks int(100)");
		unlink("includes/help.php");
		unlink("includes/style.css");
		echo "Upgrade erfolgreich!";
	}
	if($pversion == 2)
	{
		$mysql->query("ALTER TABLE cms_info ADD template text");
		$mysql->query("UPDATE cms_info SET template = 'default'");
$mysql->query("CREATE TABLE `forum_forums` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `description` text COLLATE latin1_german1_ci NOT NULL,
  `position` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("CREATE TABLE `forum_threads` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `forum` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("CREATE TABLE `forum_posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `thread` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("ALTER TABLE cms_info ADD COLUMN path");
		$mysql->query("UPDATE cms_info SET version = $version");
		$mysql->query("ALTER TABLE downloads CHANGE downloads clicks int(100)");
		unlink("includes/help.php");
		unlink("includes/style.css");
		echo "Update erfolgreich!";
	}
	if($pversion == 3)
	{
		unlink("includes/style.css");
$mysql->query("CREATE TABLE `forum_forums` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `description` text COLLATE latin1_german1_ci NOT NULL,
  `position` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("CREATE TABLE `forum_threads` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `forum` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("CREATE TABLE `forum_posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `thread` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("ALTER TABLE cms_info ADD COLUMN path");
unlink("includes/help.php");
		$mysql->query("UPDATE cms_info SET version = $version");
		$mysql->query("ALTER TABLE downloads CHANGE downloads clicks int(100)");
		echo "Update erfolgreich!";
	}
	if($pversion == 4)
	{
$mysql->query("CREATE TABLE `forum_forums` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `description` text COLLATE latin1_german1_ci NOT NULL,
  `position` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("CREATE TABLE `forum_threads` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `forum` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("CREATE TABLE `forum_posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `thread` text COLLATE latin1_german1_ci NOT NULL,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
$mysql->query("ALTER TABLE cms_info ADD COLUMN path");
unlink("includes/help.php");
		$mysql->query("UPDATE cms_info SET version = $version");
		$mysql->query("ALTER TABLE downloads CHANGE downloads clicks int(100)");
		echo "Upgrade erfolgreich";
	}
	if($pversion == 5)
	{
		$mysql->query("DROP TABLE forum_cats");
		$mysql->query("ALTER TABLE forum_forums DROP COLUMN cat");
		$mysql->query("ALTER TABLE forum_threads DROP COLUMN position");
		$mysql->query("ALTER TABLE cms_info ADD COLUMN path");
		unlink("includes/help.php");
		$mysql->query("UPDATE cms_info SET version = $version");
		$mysql->query("ALTER TABLE downloads CHANGE downloads clicks int(100)");
		echo "Upgrade erfolgreich";
	}
	if($pversion == 6)
	{
	$mysql->query("ALTER TABLE cms_info ADD COLUMN path");
	unlink("includes/help.php");
	$mysql->query("UPDATE cms_info SET version = $version");
	$mysql->query("ALTER TABLE downloads CHANGE downloads clicks int(100)");
	echo "Upgrade erfolgreich";
	}
	if($pversion == 7)
	{
		unlink("includes/help.php");
		$mysql->query("UPDATE cms_info SET version = $version");
		$mysql->query("ALTER TABLE downloads CHANGE downloads clicks int(100)");
		echo "Upgrade erfolgreich";
	}
	if($pversion == 8)
	{
		$mysql->query("ALTER TABLE downloads CHANGE downloads clicks int(100)");
		$mysql->query("UPDATE cms_info SET version = $version");
		echo "Upgrade erfolgreich";
	}
}
echo '<form action="index.php" method="post">
<input type="submit" name="installdeletefiles" value="Installations Dateien löschen">
</form></div>';
}
?>