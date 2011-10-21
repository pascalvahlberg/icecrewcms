<body>
<?php
include "includes/header.php";
if(isset($getid))
{
	echo "<title>Aktivierung - $sitename</title>";
	$mysql->query("UPDATE accounts SET active = '1' WHERE id = '$getid'");
	$mysql->query("SELECT username FROM accounts WHERE id = '$getid'");
	while($sql = mysql_fetch_array($mysql->result))
	{
		echo "<div id='Index'><p>Du hast deinen Account ".$sql['username']." erfolgreich aktiviert!</p></div>";
	}
}
?>
</body>