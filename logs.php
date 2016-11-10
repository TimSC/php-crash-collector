<?php
require_once("config.php");
session_start();
if ($_SESSION["user"] != "admin")
{
	header( 'Location: login.php' ) ;
	exit;
}

?>

<html>
<body>
<table>

<?php
echo "<p>Logged in as ".$_SESSION["user"]." <a href='logout.php'>Log out</a></p>";
$db = new LogDB();

$results = $db->query('SELECT uuid, program, times FROM logs');

while ($row = $results->fetchArray()) {
?>
<tr>
<?php
echo "<td><a href='crashlog.php?uuid=".$row["uuid"]."'>".gmdate("Y-m-d H:i:s", $row["times"])."</a></td><td>".$row["program"]."</td>";

?>
</tr>
<?php
}

?>

</table>
</body>
</html>

