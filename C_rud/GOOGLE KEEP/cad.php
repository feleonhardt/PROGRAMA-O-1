<!DOCTYPE html>
<?php
include_once "acao.php";
$acao = isset($_GET['acao']) ? $_GET['acao'] : "";
$dados;
if ($acao == 'editar'){
    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : "";
    if ($codigo > 0)
        $dados = buscarDados($codigo);
}
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>
<body>
<nav>
    <div class="nav-wrapper teal lighten-2">
        <div class="container">
            <a href="" class="brand-logo">ANOTAÇÕES - adicionar</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="index.php">HOME</a></li>
                <li><a href="cad.php">NOVA NOTA</a></li>
            </ul>
        </div>
    </div>
  </nav>
<br>
<div class="container center">
    <form action="acao.php" method="post">
        <div class="row">
            <div class="col l1 offset-l3">
                Código: <input readonly  type="text" name="codigo" id="codigo" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo 0; ?>"><br>
            </div>
            <div class="col l5">
                Título: <input required=true   type="text" name="titulo" id="titulo" value="<?php if ($acao == "editar") echo $dados['titulo']; ?>"><br>
            </div>
        </div>
        <div class="row">
            <div class="col l6 offset-l3">
                Texto: <textarea name="texto" id="texto" cols="30" rows="10"><?php if ($acao == "editar") echo $dados['texto']; ?></textarea> <br>
            </div>
        </div>
        <div class="row">
            <div class="col l6 offset-l3">
                Tags: <input required=true placeholder="Digite as tags separadas apenas por '#'" type="text" name="tags" id="tags" value="<?php if ($acao == "editar") echo $dados['tags']; ?>"><br>
            </div>
        </div>
        <div class="row">
            <div class="col l3 offset-l3">
            Cor de fundo: <input required=true   type="color" name="cor_fundo" id="cor_fundo" value="<?php if ($acao == "editar") echo $dados['cor_fundo']; ?>"><br>
            </div>
            <div class="col l3">
            Estrela: 
                <label>
                    <input required=true   type="radio" name="star" id="star" value="1" <?php if ($acao == "editar" and $dados['star']==1) echo "checked"; elseif($acao != "editar") echo "checked";?>>
                    <span>SIM</span>
                </label> |
                <label>
                    <input required=true   type="radio" name="star" id="star" value="0" <?php if ($acao == "editar" and $dados['star']==0) echo "checked"; ?>>
                    <span>NÃO</span>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col l6 offset-l3">
                <button class="btn-large" type="submit" name="acao" id="acao" value="salvar">adicionar</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>