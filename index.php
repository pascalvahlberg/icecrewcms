<body>
<?php
if(file_exists('includes/config.php') AND file_exists('includes/config.php.new')) {
echo '<meta http-equiv="refresh" content="0; URL=upgrade.php">';
}
elseif(!file_exists('includes/config.php') AND file_exists('includes/config.php.new')) {
echo '<meta http-equiv="refresh" content="0; URL=install.php">';
}
{ #Anderes Bereich
require_once("includes/header.php");
if(isset($_POST["installdeletefiles"])) {
unlink("install.php");
unlink("upgrade.php");
}
}
{ #Index Bereich
echo "<title>Index - $sitename</title>";
$mysql->query("select * from news order by id desc");
while($sql = mysql_fetch_array($mysql->result)) {
$views = $sql['views'];
echo '<div id="Index"><p><a href="view.php?page=News&ID='.$sql["id"].'"><b><u>'.$sql["name"].' (von '.$sql['username'].', '.$views.' Aufrufe)</u></b></a><br><br>'.$sql["text"].'</p></div><br>';
}
}
?>
</body>