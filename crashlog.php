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

<?php
echo "<p>Logged in as ".$_SESSION["user"]."</p>";
$db = new LogDB();

$stmt = $db->prepare('SELECT program, times, data FROM logs WHERE uuid=:uuid');
$stmt->bindValue(':uuid', $_GET["uuid"]);
$results = $stmt->execute();

while ($row = $results->fetchArray()) {
	echo "<h2>".$row["program"]." crash at ".gmdate("Y-m-d H:i:s", $row["times"])."</h2>";

	echo "<table>\n";
	foreach (json_decode($row["data"]) as $k => $v)
	{
		echo "<tr><td>".$k."</td><td><pre>".$v."</pre></td></tr>";
	}
	echo "</table>\n";
}


?>
<a href="logs.php">Back to logs</a>
</body>
</html>
