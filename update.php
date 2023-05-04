<?php

if (php_sapi_name() !== 'cli') {
    die("Meant to be run from command line");
}



require(__DIR__ . '/../../../wp-config.php');

$dbconfig = new stdClass();

$dbconfig->dbname = DB_NAME;
$dbconfig->dbuser = DB_USER;
$dbconfig->dbpassword = DB_PASSWORD;
$dbconfig->dbhost = DB_HOST;




(new \KLib\Tool\MysqlUpdater(__DIR__ . '/update', $dbconfig))->executeUpdates();
