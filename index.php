<?php
include_once __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/conn/db.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$teste = $_ENV['DB_DATABASE'];

$db = new db($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE'], $_ENV['DB_CHARSET']);

$teste = $db->query("SELECT * FROM cidades LIMIT 1")->fetchAll();

print_r($teste);