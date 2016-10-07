<?php
// performance test to compare PDO::query vs PDO::prepare/execute
// http://stackoverflow.com/a/39921429/4233593

$pdo = require __DIR__.'/data/pdos/pdo.php';

$logs = [];

$test = function (String $type, Int $count = 3000) use ($pdo, &$logs) {
	$start = microtime(true);
	$i = 0;
	while ($i < $count) {
		$sql = "INSERT INTO performancetest (id, val) OUTPUT INSERTED.sid VALUES ($i,'value $i')";
		if ($type === 'query') {
			$smt = $pdo->query($sql);
		} else {
			$smt = $pdo->prepare($sql);
			$smt ->execute();
		}
		$sid = $smt->fetch(PDO::FETCH_ASSOC)['sid'];
		$i++;
	}
	$total = (microtime(true) - $start);
	$logs[$type] []= $total;
	echo "$total $type\n";
};

if (isset($argv[1]) && $argv[1] === 'create') {
	$ddl = "
		IF (
			EXISTS (
				SELECT *
				FROM INFORMATION_SCHEMA.TABLES
				WHERE TABLE_NAME = 'performancetest'
				-- AND TABLE_SCHEMA = 'dbo'
			)
		)
		BEGIN
			DROP TABLE performancetest;
		END

		CREATE TABLE performancetest (
			sid INT IDENTITY PRIMARY KEY,
			id INT,
			val VARCHAR(100)
		);
	";
	$pdo->exec($ddl);

	// must exit because first insert trial will be biased long
	$test('prepare');
	$test('query');
	die("created performancetest\n");
}

$trials = 15;
$i = 0;
while ($i < $trials) {
	if (random_int(0,1) === 0) {
		$test('query');
	} else {
		$test('prepare');
	}
	$i++;
}

foreach ($logs as $type => $log) {
	$total = 0;
	foreach ($log as $record) {
		$total += $record;
	}
	$count = count($log);
	echo "($count) $type Average: ".$total/$count.PHP_EOL;
}
