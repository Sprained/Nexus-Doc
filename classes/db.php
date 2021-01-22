<?php
include_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class db
{
    public static function Retornar() {
        return mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
    }
    public static function Init() {
        date_default_timezone_set('America/Sao_Paulo');
    }
    public static function AntiInjector($text) {
        return addslashes(htmlspecialchars($text));
    }
}

db::Init();
$db = db::Retornar();