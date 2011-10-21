<body>
<?php
include 'includes/config.php';
include 'includes/menu.php';
include_once 'includes/class.mysql.php';
$domain = $_SERVER['SERVER_NAME'];
$path = str_replace("forum.php", "", $_SERVER['SCRIPT_NAME']);
if(file_exists('includes/config.php') AND file_exists('includes/config.php.new')) {
echo '<meta http-equiv="refresh" content="0; URL=upgrade.php">';
}
elseif(!file_exists('includes/config.php') AND file_exists('includes/config.php.new')) {
echo '<meta http-equiv="refresh" content="0; URL=install.php">';
}
$getforum = $_GET['f'];
$getthread = $_GET['t'];
$getpost = $_GET['p'];
$getcreate = $_GET['c'];
$getdelete = $_GET['d'];
require_once("includes/header.php");
{ # Startseite
if(empty($_GET))
{
	echo "<title>Forum - $sitename</title>";
	$mysql->query("SELECT * FROM forum_forums order by position");
	echo '<div id="Forum">';
	while($forum = mysql_fetch_array($mysql->result))
	{
		echo '<li><a id="F" href="forum.php?f='.$forum["id"].'">'.$forum["name"].'</a>'.$forum["description"].'</li>';
	}
	echo '</div>';
}
}
{ # Foren
if(isset($getforum) and empty($getcreate) and empty($getdelete))
{
	$mysql->query("SELECT * FROM forum_forums WHERE id = '$getforum'");
	$ffinfo = mysql_fetch_array($mysql->result);
	echo '<title>'.$ffinfo["name"].' - Forum - '.$sitename.'</title>';
	echo '<div id="Forum"><a id="F" href="forum.php?f='.$getforum.'&c=t">Thema erstellen</a>';
	$mysql->query("SELECT * FROM forum_threads WHERE forum = '$getforum' order by id desc");
	while($thv = mysql_fetch_array($mysql->result))
	{
		echo '<li><a id="F" href="forum.php?t='.$thv["id"].'">'.$thv["name"].'</a>Von '.$thv["user"].'</li>';
	}
	echo '</div>';
}
}
{ # Threads
if(isset($getthread) and empty($getcreate))
{
	$mysql->query("SELECT * FROM forum_threads WHERE id = '$getthread'");
	$ftinfo = mysql_fetch_array($mysql->result);
	echo '<title>'.$ftinfo["name"].' - Forum - '.$sitename.'</title>';
	$mysql->query("SELECT * from forum_posts WHERE thread = '$getthread' order by id");
	while($pov = mysql_fetch_array($mysql->result))
	{
		if(isset($_COOKIE[$cp.'_admin_id']))
		{
			echo '<div id="Forum"><a id="F"><p>'.$pov["user"].'</p></a> <a id="F" href="forum.php?d=p&p='.$pov["id"].'&t='.$getthread.'">Beitrag löschen</a> <a id="F" href="forum.php?d=t&t='.$getthread.'">Thema löschen</a></div>
			<div id="Forum"><p>'.$pov["text"].'</p></div><br>';
		}
		else
		{
			echo '<div id="Forum"><a id="F"><p>'.$pov["user"].'</p></a></div>
			<div id="Forum"><p>'.$pov["text"].'</p></div><br>';
		}
	}
	if(isset($_COOKIE[$cp.'_user_id']))
	{
		echo '<div id="Forum"><p>
		<form action="" method="post">
		<textarea name="text" style="width:100%; height:275"></textarea><br>
		<input type="submit" name="submit" value="Beitrag einreichen">
		</form></p></div>';
		if(isset($_POST["submit"]))
		{
			$text = str_replace("\r\n", "<br>", $_POST['text']);
			$text = str_replace('href="', 'href="redirect.php?ID=', $text);
			$text = str_replace("href='", "href='redirect.php?ID=", $text);
			$mysql->query("INSERT INTO forum_posts (user,thread,text) VALUES ('".$_COOKIE[$cp.'_user_name']."', '$getthread', '$text')");
			echo '<meta http-equiv="refresh" content="0; URL=forum.php?t='.$getthread.'">';
		}
	}
	else
	{
		echo '<div id="Forum"><p><i>Du musst dich einloggen um Beiträge schreiben zu können</i></p></div>';
	}
}
if($getdelete == "t" and isset($_COOKIE[$cp.'_admin_id']))
{
	$mysql->query("DELETE FROM forum_threads WHERE id = '$getthread'");
	$mysql->query("DELETE FROM forum_posts WHERE thread = '$getthread'");
	echo '<div id="Forum"><p>Thread erfolgreich gelöscht!</p></div>';
	echo '<meta http-equiv="refresh" content="0; URL=forum.php">';
}
if($getcreate == "t" and isset($_COOKIE[$cp.'_user_id']))
{
	echo '<title>Thema erstellen - Forum - '.$sitename.'</title>';
	echo '<div id="Forum"><p><form action="" method="post">
	Name: <input type="text" name="name"><br>
	<textarea name="text" style="width:100%; height:275"></textarea><br>
	<input type="submit" name="submit" value="Thema erstellen">
	</form>
	</p></div>';
	if(isset($_POST["submit"]))
	{
		$text = str_replace("\r\n", "<br>", $_POST['text']);
		$text = str_replace('href="', 'href="redirect.php?ID=', $text);
		$text = str_replace("href='", "href='redirect.php?ID=", $text);
		$mysql->query("INSERT INTO forum_threads (name,user,forum) VALUES ('".$_POST['name']."', '".$_COOKIE[$cp.'_user_name']."', '$getforum')");
		$mysql->query("SELECT id FROM forum_threads WHERE name = '".$_POST['name']."'");
		$sql = mysql_fetch_array($mysql->result);
		$mysql->query("INSERT INTO forum_posts (user,thread,text) VALUES ('".$_COOKIE[$cp.'_user_name']."', '".$sql['id']."', '$text')");
		echo '<meta http-equiv="refresh" content="0; URL=forum.php?t='.$sql["id"].'">';
	}
}
}
{ # Beiträge
if(isset($getpost) and isset($_COOKIE[$cp.'_admin_id']))
{
	$mysql->query("DELETE FROM forum_posts WHERE id = '$getpost'");
	echo '<meta http-equiv="refresh" content="0; URL=forum.php?t='.$getthread.'">';
}
}
?>
</body>
