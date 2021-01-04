<?php
include_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$teste = $_ENV['DB_DATABASE'];
echo $teste;