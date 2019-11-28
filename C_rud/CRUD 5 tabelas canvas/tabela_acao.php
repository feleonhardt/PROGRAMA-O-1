<?php
  include_once "assets/conf/default.inc.php";
  require_once "assets/conf/Conexao.php";
  $pdo = Conexao::getInstance();
  $excluir = isset($_GET['excluir']) ? $_GET['excluir'] : null;
  $tabela = isset($_GET['tabela']) ? $_GET['tabela'] : 'estados';
  if ($excluir != null) {
    $exclusao = $pdo->query("DELETE from {$tabela} where codigo = {$excluir};");
    $exclusao->execute();
  }
  header('location:tabela.php');
 ?>
