<?php
include_once __DIR__ . '/classes/infos_planos.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="classes/cadastro.php" method="POST">
        <input type="text" name='nome' placeholder="Nome completo">
        <input type="text" name='senha' placeholder="Senha">
        <input type="text" name='telefone' placeholder="Telefone">
        <input type="text" name='cpf' placeholder="CPF">
        <input type="text" name='email' placeholder="Email">
        <button type="submit">Cadastrar</button>

        <?php foreach($infos as $value){ ?>
            <div>
                <h1><?=$value['nome_plano']?></h1>
                <p>R$ <?=$value['preco_plano']?></p>
                <input type="checkbox" name="plano" value="<?=$value['id_plano']?>">
                <?php foreach($value['infos_plano'] as $item){ ?>
                    <p><?=$item?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </form>
</body>
</html>