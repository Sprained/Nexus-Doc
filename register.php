<?php
include_once __DIR__ . '/classes/infos_planos.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="lib/toastr/toastr.min.css" rel="stylesheet"/>

    <script src="lib/jquery/jquery-3.5.1.min.js"></script>
    <script src="lib/toastr/toastr.min.js"></script>

    <title>Register</title>
</head>
<body>
    <form>
        <input type="text" name='nome' placeholder="Nome completo">
        <input type="text" name='senha' placeholder="Senha">
        <input type="text" name='telefone' placeholder="Telefone">
        <input type="text" name='cpf' placeholder="CPF">
        <input type="text" name='email' placeholder="Email">
        <input type="text" name='cep' placeholder="CEP" maxlength="8">
        <input type="text" name='rua' value="" placeholder="Rua">
        <input type="text" name='numero' placeholder="Numero">
        <input type="text" name='cidade' placeholder="Cidade">
        <input type="text" name='uf' placeholder="UF">
        <input type="text" name='complemento' placeholder="Complemento">
        <input type="text" name='municipio' placeholder="Bairro">
        <button type="submit" id="submitButtom">Cadastrar</button>

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

    <script src="js/register.js"></script>
</body>
</html>