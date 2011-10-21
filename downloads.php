<body>
<?php
include "includes/header.php";
if(empty($getid)) {
echo "<title>Downloads - $sitename</title>";
$mysql->query("select * from downloads order by id desc");
echo "<div id='Index'><p>";
while($dl = mysql_fetch_array($mysql->result)) {
$ext = pathinfo("downloads/".$dl['id']."/".$dl['filename']);
$size = round(filesize("downloads/".$dl['id']."/".$dl['filename']) / 1024 / 1024, 2);
echo "<a href='?ID=".$dl['id']."'>".$dl['name']."</a> ($size MB, ".$dl['clicks']." Klicks, ".$ext['extension'].")<br>";
}
echo "</p></div>";
}
if(isset($getid)) {
$mysql->query("select * from downloads where id = '$getid'");
while($dl = @mysql_fetch_array($mysql->result))
{
$dlc = $dl['clicks'] + 1;
$ext = pathinfo("downloads/".$dl['id']."/".$dl['filename']);
$size = round(filesize("downloads/".$dl['id']."/".$dl['filename']) / 1024 / 1024, 2);
echo "<title>".$dl['name']." - Downloads - $sitename</title>";
echo '<div id="Index"><p><h1>'.$dl["name"].'</h1>
<b>Dateiname</b>: '.str_replace('.'.$ext["extension"], "", $dl["filename"]).'<br>
<b>Dateiendung</b>: '.$ext["extension"].'<br>
<b>Dateigröße</b>: '.$size.' MB<br>
<b>Popularität</b>: '.$dlc.' Klicks<br>
<br>
<a href="downloads/'.$dl['id'].'/'.$dl['filename'].'" id="N">Download</a>
</p></div>';
$mysql->query("UPDATE downloads SET clicks = '$dlc' WHERE id='$getid'");
}
}
?>
</body>