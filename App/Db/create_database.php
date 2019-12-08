<?php

require dirname(__DIR__) . '/../vendor/autoload.php';
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

print "======== LOADING ENVIRONMENT VARIABLES ========\n";
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__) . '/../');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_USER', 'DB_PASSWORD']);


print "======== CONNECTING TO DATABASE SERVER ========\n";
$host = $_ENV['DB_HOST'];
$dbh = new PDO("mysql:host=$host", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

print "========     RUNNING CREATION SCRIPT   ========\n";
$dbh->exec(file_get_contents(dirname(__DIR__) . '/Db/CreateDB.sql'));

print '========              DONE             ========';
