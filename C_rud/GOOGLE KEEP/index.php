<!DOCTYPE html>
<?php
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";

include("funcoes.php");

$title = "Lista de Marcas";
$consulta = isset($_GET['consulta']) ? $_GET['consulta'] : "";
$opcao = isset($_GET['opcao']) ? $_GET['opcao'] : "";
$estrela = isset($_GET['estrela']) ? $_GET['estrela'] : "";
?>
<html>
<head>
    <meta charset="UTF-8">
    <title> <?php echo $title; ?> </title>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
        function recuperarRegistro(url) {
            if (confirm("Confirmar Recuperação?"))
                location.href = url;
        }
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>
<body>
<nav>
    <div class="nav-wrapper teal lighten-2">
        <div class="container">
            <a href="" class="brand-logo">ANOTAÇÕES - <?php if ($ativa == 0) {
                echo "excluídas";
            }else {
                echo "ativas";
            } ?></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="acao.php?acao=ativa">NOTAS <?php if ($ativa == 0) {
        echo "ATIVAS";
    }else {
        echo "EXCLUÍDAS";
    } ?></a></li>
                <li><a href="cad.php">NOVA NOTA</a></li>
            </ul>
        </div>
    </div>
  </nav>
  <br>
    <form method="get">
    <div class="container" style="background-color: rgba(0,0,255,0.05); border-radius: 15px;">
        <div class="row">
            <div class="col l10">
                <input type="text" placeholder="Digite sua busca..." name="consulta" id="consulta" value="<?php echo $consulta; ?>">
            </div>
            <div class="col l2">
                <input class="btn-large" type="submit" value="Pesquisar">
            </div>
        </div>
        <div class="row">
            <div class="col l3">
                Buscar por:
                <label>
                    <input type="radio" name="opcao" id="opcao" value="texto" <?php if($consulta == ""){echo "checked";}elseif($consulta != "" and $opcao=="texto"){echo "checked";} ?>>
                    <span>Texto</span>
                </label>  | 
                <label>
                    <input type="radio" name="opcao" id="opcao" value="tag" <?php if($consulta != "" and $opcao=="tag"){echo "checked";} ?>>
                    <span>Tag</span>
                </label>
            </div>
            <div class="col l3">
                Notas:
                <label>
                    <input type="radio" name="estrela" id="estrela" value="0" <?php if($consulta == "" and $estrela == ""){echo "checked";}elseif($consulta == "" and $estrela=="0"){echo "checked";}elseif($consulta != "" and $estrela=="0"){echo "checked";} ?>> 
                    <span>Todas</span>
                </label>  | 
                <label>
                <input type="radio" name="estrela" id="estrela" value="1" <?php if($consulta != "" and $estrela=="1"){echo "checked";}elseif($consulta == "" and $estrela=="1"){echo "checked";} ?>>
                <span>Favoritas</span>
                </label>
            </div>
        </div>
    </div>
    </form>
    <?php 
        apresentaNotasCards(obtemSQL());
    ?>
    
    
</body>
</html>
