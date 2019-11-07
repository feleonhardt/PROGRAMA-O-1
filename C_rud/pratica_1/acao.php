<?php
  include_once "conf/default.inc.php";
  require_once "conf/Conexao.php";



  $pdo = Conexao::getInstance();

  $stmt = $pdo->prepare("INSERT INTO marcas(descricao) values (:descricao);");
  $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
  $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
  $stmt->execute();

  echo $descricao;
 ?>
