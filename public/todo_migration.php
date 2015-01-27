<?php

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'planner');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require('db_connect.php');

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

// Create the query and assign to var
$query = 'CREATE TABLE todo_list (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    task VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)';

// Run query, if there are errors they will be thrown as PDOExceptions
$dbc->exec($query);