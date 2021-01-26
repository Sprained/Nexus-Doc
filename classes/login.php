<?php
include __DIR__ . '/db.php';
require __DIR__ . '/validator.php';

$validator = new Validator();

$email = $validator->email($_POST['email']);
$senha = $validator->password($_POST['senha']);

$user = $db->query("SELECT u.id, u.nome_completo AS nome, u.email, up.id_planos FROM usuarios u INNER JOIN usuarios_planos up ON u.id = up.id_usuarios WHERE email = '$email' AND senha = '$senha'")->fetch_assoc();
if(!$user) {
    header("HTTP/1.0 401 Unauthorized");
    echo "Email ou senha invalidos!";
    die();
}

session_start();

$_SESSION['user'] = $user;

echo "Usuario logado com sucesso";