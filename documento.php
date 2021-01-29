<?php
include __DIR__ . '/classes/db.php';

session_start();

$sql = "SELECT IF(p.qtd_doc >= count(d.id), true, false) AS permission

        FROM planos p 

        INNER JOIN usuarios_planos up ON 
        up.id_planos = p.id 

        LEFT JOIN documento d ON
        d.id_usuario = up.id_usuarios

        WHERE up.id_usuarios = " . $_SESSION['user']['id'];
$permission = $db->query($sql)->fetch_assoc();

$planos = $db->query("SELECT id, descricao FROM tipos_documento")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="lib/jquery/jquery-3.5.1.min.js"></script>

    <title>Documento</title>
</head>
<body>
    <?php
        if($permission['permission']) {
            
    ?>
            <select name="plano">
            <option>Escolha o tipo de documento</option>
        <?php
            foreach($planos AS $value) {
        ?>
                <option value="<?=$value['id']?>"><?=$value['descricao']?></option>
        <?php
            }
        ?>
            </select>
        <button>Cadastrar</button>
    <?php
        }
    ?>

    <script src="js/documento.js"></script>
</body>
</html>