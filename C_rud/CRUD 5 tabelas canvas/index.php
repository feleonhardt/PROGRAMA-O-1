<!DOCTYPE html>
<?php
$tabela = isset($_POST['tabela']) ? $_POST['tabela'] : '';
 ?>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Menu</title>
  </head>
  <body>
    <form class="" action="" method="post">
      <center>
        <h3>TABELAS</h3>
        <button type="submit" name="tabela" value="vendedores">VENDEDORES</button> <br><br>
        <button type="submit" name="tabela" value="funcionarios">FUNCIONÁRIOS</button> <br><br>
        <button type="submit" name="tabela" value="carros">CARROS</button> <br><br>
        <button type="submit" name="tabela" value="computadores">COMPUTADORES</button> <br><br>
        <button type="submit" name="tabela" value="escolas">ESCOLAS</button> <br><br>
        <button type="submit" name="tabela" value="predios">PRÉDIOS</button> <br><br>
      </center>
    </form>
    <?php
    $dados_json= json_encode($tabela);
    $fp = fopen("table.json", "w");
    $escreve = fwrite($fp, $dados_json);
    fclose($fp);
    if (json_decode($dados_json)!="") {
      header('location:tabela.php');
    }
     ?>
  </body>
</html>
