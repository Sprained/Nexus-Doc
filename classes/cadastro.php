<?php
include __DIR__ . '/db.php';
require __DIR__ . '/validator.php';

$validator = new Validator();

$nome = trim($_POST['nome']);
$senha = $validator->password(($_POST['senha']));
$telefone = $validator->count(10, 11, 'Telefone', $_POST['telefone']);
$cpf = $validator->count(11, 11, 'CPF', $_POST['cpf']);
$email = $validator->email($_POST['email']);
$plano_id = $_POST['plano'];

$user = $db->query("SELECT cpf, email FROM usuarios where cpf = '$cpf' OR email = '$email'")->fetch_assoc();
if ($user) {
    if ($email == $user['email']) {
        header("HTTP/1.0 400 Bad Request");
        echo "Email já cadastrado!";
        die();
    }

    if ($cpf == $user['cpf']) {
        header("HTTP/1.0 400 Bad Request");
        echo "CPF já cadastrado!";
        die();
    }
}

if($db->query("INSERT INTO usuarios (nome_completo, telefone, cpf, email, senha) VALUES ('$nome', '$telefone', '$cpf', '$email', '$senha')")) {
    if($db->query("INSERT INTO usuarios_planos (id_usuarios, id_planos) VALUES ($db->insert_id, '$plano_id')")) {
        echo "Usuario cadastrado com sucesso!";
    } else {
        $db->query("DELETE FROM usuarios WHERE cpf = '$cpf'");
        header("HTTP/1.0 400 Bad Request");
        echo "Erro ao cadastar usuario!";
        die();
    }
} else {
    header("HTTP/1.0 400 Bad Request");
    echo "Erro ao cadastar usuario!";
    die();
}