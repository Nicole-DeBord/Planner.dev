<?php

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'planner');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require('db_connect.php');

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$tasks = [
	'task 1',
	'task 2',
	'task 3',
	'task 4',
	'task 5',
	'task 6',
	'task 7',
	'task 8',
	'task 9',
	'task 10',
	'task 11',
	'task 12',
	'task 13',
	'task 14',
	'task 15'
];

$query = "INSERT INTO todo_list (task) VALUES (:task)";

$stmt = $dbc->prepare($query);

foreach ($tasks as $task) {

    $stmt->bindValue(':task', $task, PDO::PARAM_STR);
    
    $stmt->execute();

    echo "Inserted ID: " . $dbc->lastInsertId() . PHP_EOL;
}