<?php
require_once("config.php");

if($_SERVER['REQUEST_METHOD'] != 'POST')
	die("Only accepts POST data");
$dataFrags = explode("\n", $_POST['data']);
if ($dataFrags[0] != hash('sha256', DB_SECRET.$dataFrags[1]))
	die("Incorrect hash");

$decData = json_decode($dataFrags[1]);

$db = new LogDB();
$db->exec('CREATE TABLE IF NOT EXISTS logs (uuid STRING, program STRING, times STRING, data STRING);');

$db->exec('CREATE INDEX IF NOT EXISTS logs_uuid_index ON logs (uuid);');

$stmt = $db->prepare("SELECT COUNT(*) FROM logs WHERE uuid = :uuid;");
$stmt->bindValue(':uuid', $decData->{'uuid'});
$results = $stmt->execute();

while ($row = $results->fetchArray()) {
    $count = $row[0]."\n";
	if ($count > 0)
	{
		echo "Record exists";
		exit(0);
	}
}

$stmt = $db->prepare("INSERT INTO logs (uuid, program, times, data) VALUES (:uuid, :program, :times, :data)");
$stmt->bindValue(':uuid', $decData->{'uuid'});
$stmt->bindValue(':program', $decData->{'program'});
$stmt->bindValue(':times', strtotime($decData->{'timestamp'}));
$stmt->bindValue(':data', $dataFrags[1]);
$result = $stmt->execute();

?>
