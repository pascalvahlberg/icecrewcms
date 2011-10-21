<body>
<?php
include "includes/header.php";
if($getpage == "Posts" and isset($getid)) {
$mysql->query("select * from posts where id='".$getid."'");
while($data = mysql_fetch_array($mysql->result)) {
$views = $data['views'] + 1;
echo "<title>".$data['name']." - $sitename</title>";
echo "<div id='Index'><p><b><u>".$data['name']." (von ".$data['username'].", $views Aufrufe)</u></b>";
if(isset($_COOKIE[$cp."_admin_id"])) {
echo " | <a href='admin.php?posts=edit&ID=$getid'>Beitrag editieren</a>";
}
echo "<br><br>";
echo $data['text'].'</p></div>';
$mysql->query("UPDATE posts SET views = $views WHERE id = '".$data['id']."'");
echo "<br><div id='Index'><p><i>Kommentare:</i><br>";
$mysql->query("select * from post_comments where position = '$getid' order by id desc");
while($comment = mysql_fetch_array($mysql->result)) {
echo "<b>".$comment['user'].":</b> ".$comment['msg'];
if(isset($_COOKIE[$cp."_admin_id"])) {
echo '<form action="" method="post"><input type="submit" value="Kommentar löschen" name="pc'.$comment["id"].'"></form>';
if(isset($_POST["pc".$comment['id']])) {
$mysql->query("DELETE FROM post_comments WHERE id = '".$comment['id']."'");
echo '<meta http-equiv="refresh" content="0; url=view.php?page=Posts&ID='.$getid.'">';
}
}
else {
echo "<br>";
}
}
echo "</div>";
if(isset($_COOKIE[$cp."_user_id"])) {
echo '<br><div id="Index"><form action="" method="post">
<textarea type="text" name="pcmsg" style="width:500; height:75"></textarea>
<input type="submit" name="pcsubmit" value="Kommentieren">
<form></div>';
}
elseif($gastkommentar == "1") {
echo '<br><div id="Index"><form action="" method="post">
Name: <input type="text" name="pcgname" size="50" maxlength="15"><br>
<textarea type="text" name="pcgmsg" style="width:500; height:75"></textarea>
<input type="submit" name="pcgsubmit" value="Kommentieren">
<form></div>';
}
else {
echo "<br><div id='Index'><i>(Du musst dich einloggen um Kommentare schreiben zu können)</i></p></div>";
}
if(isset($_POST['pcsubmit'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['pcmsg']);
$text = str_replace('href="', 'href="view.php?page=Redirect&ID=', $pretext);
$mysql->query("INSERT INTO post_comments (user, msg, position) VALUES ('".$_COOKIE[$cp.'_user_name']."', '".$text."', '".$getid."')");

echo '<meta http-equiv="refresh" content="0; url=view.php?page=Posts&ID='.$getid.'">';
}
if(isset($_POST['pcgsubmit'])) {
if(empty($_POST['pcgname'])) {
echo "<br><div id='Index'><p>Geben sie einen Namen ein!</p></div>";
}
else {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['pcgmsg']);
$text = str_replace('href="', 'href="view.php?page=Redirect&ID=', $pretext);
$mysql->query("INSERT INTO post_comments (user, msg, position) VALUES ('".$_POST['pcgname']." (Gast)', '".$text."', '".$getid."')");

echo '<meta http-equiv="refresh" content="0; url=view.php?page=Posts&ID='.$getid.'">';
}
}
}
}
if($getpage == "Posts" and empty($getid)) {
echo "<title>Alle Beiträge - $sitename</title>";
$mysql->query("select * from posts order by id desc");
echo "<div id='Index'><p>";
while($sql = mysql_fetch_array($mysql->result)) {
echo "<a href=\"view.php?page=Posts&ID=".$sql['id']."\">".$sql['name']."</a> (".$sql['views']." Aufrufe)<br>";
}
echo "</div></p>";
}
if($getpage == "News" and isset($getid)) {
$mysql->query("select * from news where id='$getid'");
while($data = mysql_fetch_array($mysql->result)) {
$views = $data['views'] + 1;
echo "<title>".$data['name']." - $sitename</title>";
echo "<div id='Index'><p><b><u>".$data['name']." (von ".$data['username'].", $views Aufrufe)</u></b>";
if(isset($_COOKIE[$cp."_admin_id"])) {
echo " | <a href='admin.php?news=edit&ID=$getid'>News editieren</a>";
}
echo "<br><br>";
echo $data['text'].'</p></div>';
$mysql->query("UPDATE news SET views = $views WHERE id = '".$data['id']."'");
echo "<br><div id='Index'><p><i>Kommentare:</i><br>";
$mysql->query("select * from news_comments where position = '$getid' order by id desc");
while($comment = mysql_fetch_array($mysql->result)) {
echo "<b>".$comment['user'].":</b> ".$comment['msg'];
if(isset($_COOKIE[$cp."_admin_id"])) {
echo '<form action="" method="post"><input type="submit" value="Kommentar löschen" name="nc'.$comment["id"].'"></form>';
if(isset($_POST["nc".$comment['id']])) {
$mysql->query("DELETE FROM news_comments WHERE id = '".$comment['id']."'");
echo '<meta http-equiv="refresh" content="0; url=view.php?page=News&ID='.$getid.'">';
}
}
else {
echo "<br>";
}
}
echo "</div>";
if(isset($_COOKIE[$cp."_user_id"])) {
echo '<br><div id="Index"><form action="" method="post">
<textarea type="text" name="ncmsg" style="width:500; height:75"></textarea>
<input type="submit" name="ncsubmit" value="Kommentieren">
<form></div>';
}
elseif($gastkommentar == "1") {
echo '<br><div id="Index"><form action="" method="post">
Name: <input type="text" name="ncgname" size="50" maxlength="15"><br>
<textarea type="text" name="ncgmsg" style="width:500; height:75"></textarea>
<input type="submit" name="ncgsubmit" value="Kommentieren">
<form></div>';
}
else {
echo "<br><div id='Index'><i>(Du musst dich einloggen um Kommentare schreiben zu können)</i></p></div>";
}
if(isset($_POST['ncsubmit'])) {
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['ncmsg']);
$text = str_replace('href="', 'href="view.php?page=Redirect&ID=', $pretext);
$mysql->query("INSERT INTO news_comments (user, msg, position) VALUES ('".$_COOKIE[$cp.'_user_name']."', '".$text."', '".$getid."')");

echo '<meta http-equiv="refresh" content="0; url=view.php?page=News&ID='.$getid.'">';
}
if(isset($_POST['ncgsubmit'])) {
if(empty($_POST['ncgname'])) {
echo "<br><div id='Index'><p>Geben sie einen Namen ein!</p></div>";
}
else {
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['ncgmsg']);
$text = str_replace('href="', 'href="view.php?page=Redirect&ID=', $pretext);
$mysql->query("INSERT INTO news_comments (user, msg, position) VALUES ('".$_POST['ncgname']." (Gast)', '".$text."', '".$getid."')");

echo '<meta http-equiv="refresh" content="0; url=view.php?page=News&ID='.$getid.'">';
}
}
}
}
if($getpage == "News" and empty($getid)) {
echo "<title>Alle News - $sitename</title>";
$mysql->query("select * from news order by id desc");
echo "<div id='Index'><p>";
while($sql = mysql_fetch_array($mysql->result)) {
echo "<a href=\"view.php?page=News&ID=".$sql['id']."\">".$sql['name']."</a> (".$sql['views']." Aufrufe)<br>";
}
echo "</p></div>";
}
if($getpage == "Impressum") {
echo "<title>Impressum - $sitename</title>";
echo "<div id='Index'><p>Name: $impressum_name<br>
Land: $impressum_land<br>
Ort: $impressum_postleitzahl $impressum_stadt<br>
Straße: $impressum_straße $impressum_hausnummer<br>
E-Mail: <a href='mailto:$impressum_email'>$impressum_email</a><br>
Telefon: $impressum_telefon</p>
</div>";
}
?>
</body>