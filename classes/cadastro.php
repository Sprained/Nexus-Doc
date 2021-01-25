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
$cep = $_POST['cep'];
$rua = $_POST['rua'];
$numero = $validator->num($_POST['numero'], 'Número');
$complemento = $_POST['complemento'] ? $_POST['complemento'] : null;
$bairro = $_POST['municipio'];
$cidade = $_POST['cidade'];
$uf = $_POST['uf'];

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

// CADASTRO DE USUÁRIO
$user = $db->prepare("INSERT INTO usuarios (nome_completo, telefone, cpf, email, senha) VALUES (?,?,?,?,?)");
$user->bind_param('sssss', $nome, $telefone, $cpf, $email, $senha);

if($user->execute()) {
    // CADASTRO DE ENDEREÇO DO USUÁRIO (COBRANÇA)
    $endereco = $db->prepare("INSERT INTO usuarios_endereco (cep, rua, numero, cidade, uf, complemento, municipio) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $endereco->bind_param('ssissss', $cep, $rua, $numero, $cidade, $uf, $complemento, $bairro);

    if($endereco->execute()){
        // CADASTRO DE PLANO DO USUÁRIO
        $plano = $db->prepare("INSERT INTO usuarios_planos (id_usuarios, id_planos) VALUES (?, ?)");
        $id = $user->insert_id;
        $plano->bind_param('ii', $id, $plano_id);
    
        if($plano->execute()) {
            echo "Usuario cadastrado com sucesso!";
        } else {
            // CASO DE ERRO NO CADASTRO DE USUÁRIO
            $db->query("DELETE FROM usuarios WHERE cpf = '$cpf'");
            $db->query("DELETE FROM endereco_usuario WHERE id = '$endereco->insert_id'");
            header("HTTP/1.0 400 Bad Request");
            echo "Erro ao cadastrar usuario!";
            die();
        }
    } else {
         // CASO DE ERRO NO CADASTRO DE ENDEREÇO
         $db->query("DELETE FROM usuarios WHERE cpf = '$cpf'");
         header("HTTP/1.0 400 Bad Request");
         echo "Erro ao cadastrar usuario!";
         die();
    }
} else {
    header("HTTP/1.0 400 Bad Request");
    echo "Erro ao cadastrar usuario!";
    die();
}