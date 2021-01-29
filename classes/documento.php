<?php

include __DIR__ . '/db.php';
require __DIR__ . '/validator.php';
use Dompdf\Dompdf;

session_start();

$validator = new Validator();

//VERIFICAÇÃO PLANO USUARIO
$sql = "SELECT IF(p.qtd_mes != 0, true, false) AS permission

        FROM planos p 

        WHERE p.id = '" . $_SESSION['user']['id_planos'] . "'";
$plano = $db->query($sql)->fetch_assoc();

//REQUISIÇÃO POST
$nome_instituicao = $validator->required(trim($_POST['instituicao']), 'Instituição');
$nome_curso = $validator->required(trim($_POST['curso']), 'Curso');
// $nome_autores = $validator->required($_POST['autor[]'], 'Autor');
$nome_autores = $_POST['autor'];
$titulo = $validator->required(trim($_POST['titulo']), 'Título');
$subtitulo = trim($_POST['subtitulo']) ? trim($_POST['subtitulo']) : null;
$cidade = $validator->required(trim($_POST['cidade']), 'Cidade');
$ano = $validator->num($_POST['ano'], 'Ano');

//GERAÇÃO DOCUMENTO
$obj = [
    'nome_instituicao' => $nome_instituicao,
    'nome_curso' => $nome_curso,
    'nome_autores' => $nome_autores[0],
    'titulo' => $titulo,
    'subtitulo' => $subtitulo,
    'cidade' => $cidade,
    'ano' => $ano
];

$ch = curl_init("http://localhost/dev/Nexus%20Doc/docs/abnt.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $obj);
$content = curl_exec($ch);
curl_close($ch);

$dompdf = new Dompdf();
$dompdf->loadHtml($content);

// VERIFICAÇÃO SE O PLANO DE USUÁRIO PERMITE SALVAR O DOC
if ($plano['permission']) {
    // CADASTRO DO DOCUMENTO
    $doc = $db->prepare("INSERT INTO documento (nome_documento, id_usuario, id_tipo_doc) VALUES (?, ?, ?)");
    $doc->bind_param('sii', $titulo, $_SESSION['user']['id'], $_SESSION['id_plano']);

    if ($doc->execute()) {
        // CADASTRO DAS INFOS DA CAPA DO DOCUMENTO
        $doc_capa = $db->prepare("INSERT INTO documento_capa (id_documento, nome_instituicao, nome_curso, titulo, subtitulo, cidade, ano) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $id_doc = $doc->insert_id;
        $doc_capa->bind_param('isssssi', $id_doc, $nome_instituicao, $nome_curso, $titulo, $subtitulo, $cidade, $ano);

        if ($doc_capa->execute()) {
            // CADASTRO DOS AUTORES DO DOCUMENTO
            
            $array = [];
            foreach ($nome_autores as $autor) {
                array_push($array, $doc_capa->insert_id, $autor);
            }

            $doc_autor = $db->prepare("INSERT INTO documento_autores (id_documento_capa, nome_autor) VALUES " . str_repeat('(?,?), ', count($nome_autores) - 1) . "(?,?)");
            $doc_autor->bind_param(str_repeat('is', count($nome_autores)) , ...$array);

            if(!$doc_autor->execute()) {
                $db->query("DELETE FROM documento WHERE id_usuario = '" . $_SESSION['user']['id'] . "'");
                $db->query("DELETE FROM documento_capa WHERE id_documento = '$doc_autor->insert_id'");
                $db->query("DELETE FROM documento_autores WHERE id_documento_capa = '$doc_capa->insert_id'");
                header("HTTP/1.0 400 Bad Request");
                echo "Erro ao cadastrar capa!";
                die();
            }
        } else {
            // CASO DE ERRO NO CADASTRO NAS TABELAS DOS DOCUMENTOS
            $db->query("DELETE FROM documento WHERE id_usuario = '" . $_SESSION['user']['id'] . "'");
            $db->query("DELETE FROM documento_autores WHERE id_documento_capa = '$doc_capa->insert_id'");
            header("HTTP/1.0 400 Bad Request");
            echo "Erro ao cadastrar capa!";
            die();
        }
    } else {
        // CASO DE ERRO NO CADASTRO DO DOCUMENTO
        header("HTTP/1.0 400 Bad Request");
        echo "Erro ao cadastrar capa!";
        die();
    }
}

$dompdf->render();
$dompdf->stream();