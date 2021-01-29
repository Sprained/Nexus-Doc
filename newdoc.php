<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Documento</title>
</head>
<body>
    <form action="classes/documento.php" method="POST">
        <input type="text" name="instituicao" placeholder="Instituição">
        <input type="text" name="curso" placeholder="Nome do Curso">
        <div>
            <input type="text" name="autor[]" placeholder="Nome do autor"> <button>+</button>
        </div>
        <input type="text" name="titulo" placeholder="Titulo">
        <input type="text" name="subtitulo" placeholder="Subtitulo (Não obrigatorio)">
        <input type="text" name="cidade" placeholder="Cidade">
        <input type="text" name="ano" value="<?=date('Y')?>">

        <button type="submit">Enviar</button>
    </form>
</body>
</html>