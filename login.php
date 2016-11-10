<?php
require_once("config.php");
session_start();

$message = NULL;
$success = false;
if (isset($_POST["login"]))
{
	if($_POST["password"]==ADMIN_PASSWORD)
	{
		$_SESSION["user"] = "admin";
		$message = "Log in success";
		$success = true;
	}
	else
	{
		$_SESSION["user"] = NULL;
		$message = "Log in failed";
	}

}

if ($success)
{
	header( 'Location: logs.php' ) ;
	exit;
}

?>
<html>
<body>
<?php
if ($message != NULL)
{
	echo "<p>".$message."</p>";
}
if (!isset($_SESSION["user"]) or $_SESSION["user"] == null)
{
?>
<form method="POST">
Admin password: <input type="password" name="password"/>
<input type="submit" name="login" value="Log in"/>
</form>
<?php
}
?>
<a href="logs.php">Back to logs</a>
</body>
</html>
