<?php
include_once "assets/conf/default.inc.php";
require_once "assets/conf/Conexao.php";
$pdo = Conexao::getInstance();

$menu = isset($_POST['menu']) ? $_POST['menu'] : false;

$arquivo = file_get_contents('table.json');
$tabela = json_decode($arquivo);
if ($tabela == '') {
  header("location:index.php");
}
if ($menu == true) {
  header("location:index.php");
}

function recebeFormulario($tabela){
  $field = $GLOBALS['pdo']->query("SHOW COLUMNS FROM {$tabela};");
  $inputs = array();
  $cont=0;
  while ($linha = $field->fetch(PDO::FETCH_ASSOC)) {
    if ($linha['Key'] != 'PRI') {
      $inputs[] = $linha['Field'];
      $cont++;
    }
  }
  $contador=0;
  $acao = isset($_POST['acao']) ? $_POST['acao'] : '';
  if ($acao) {
    for ($i=0; $i < count($inputs) ; $i++) {
      if ($_POST["novo_{$inputs[$i]}"]) {
        $contador++;
      }
    }
  }
  if ($contador == $cont) {
    $camposBind = array();
    for ($v=0; $v < count($inputs) ; $v++) {
      $camposBind[] = ":".$inputs[$v];
    }
    $comando = "insert INTO {$tabela}(";
    for ($i=0; $i < count($inputs) ; $i++) {
      if ($i != 0) {
        $comando .= ", ";
      }
      $comando .= "{$inputs[$i]}";
    }
    $comando .= ") values (";
    for ($i=0; $i < count($inputs) ; $i++) {
      if ($i != 0) {
      $comando .= ", ";
      }
      $comando .= ":".$inputs[$i];
    }
    $comando .= ");";
    $sql = $GLOBALS['pdo']->prepare($comando);
    for ($x=0; $x < count($inputs) ; $x++) {
      $sql->bindParam(":{$inputs[$x]}", $_POST["novo_{$inputs[$x]}"]);
    }
    $sql->execute();
  }
}

function apresentaFormulario($tabela){
  echo "<fieldset>";
  echo "<form action='add.php' method='post' border='1px'>";
  echo "ADICIONAR REGISTRO <br><br>";
  $field = $GLOBALS['pdo']->query("SHOW COLUMNS FROM {$tabela};");
  while ($linha = $field->fetch(PDO::FETCH_ASSOC)) {
    // echo substr($linha['Type'], 0, 5). "<br><Br>";
    if ($linha['Key'] != 'PRI') {
      echo $linha['Field'];
      //$inputs = "novo_".$linha['Field'];
      if ($linha['Type'] == 'date') {
        ?>
        <input type="date" name="novo_<?php echo $linha['Field']; ?>" value=""> <br>
        <?php
      }else if (substr($linha['Type'], 0, 3) == 'int') {
        ?>
        <input type="number" name="novo_<?php echo $linha['Field']; ?>" value=""> <br>
        <?php
      }else {
        ?>
        <input type="text" name="novo_<?php echo $linha['Field']; ?>" value=""> <br>
        <?php
      }
    }
    ?>
    <input type="hidden" name="tabela" value="<?php echo $tabela; ?>">
    <?php
    // $linha['Field']
  }
  echo "<br>";
  echo "<input type='submit' name='acao' value='ADICIONAR'>";
  echo "</form>";
  echo "</fieldset>";
}

function apresentaTabela($conexao, $tabela){
  echo "<table border='1px'>";
    $field = $GLOBALS['pdo']->query("SHOW COLUMNS FROM {$tabela};");
    echo "<tr>";
    $colunas = array();
    while ($linha = $field->fetch(PDO::FETCH_ASSOC)) {
      echo "<th>{$linha['Field']}</th>";
      $colunas[] = $linha['Field'];
    }
    echo "<th>Ação</th>";
    echo "</tr>";
    $count = 0;
    while ($linha = $conexao->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      for ($i=0; $i < count($colunas) ; $i++) {
        echo "<td>{$linha[$colunas[$i]]}</td>";
      }
      echo "<td>";
      ?>
      <a href="javascript:excluir('tabela_acao.php?tabela=
      <?php echo $tabela; ?>
      &excluir=
      <?php echo $linha['codigo']; ?>
      ')">Excluir</a>
      <?php
      echo "</td></tr>";
      $count++;
    }
    if ($count==0) {
      echo "<tr><td colspan='4'>Nenhum registro!</td></tr>";
    }
    echo "</table>";
}
?>
<script>
 function excluir(url) {
     if(confirm("Confirmar exclusão?")){
       location.href=url;
     }
 }
</script>
