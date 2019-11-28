<?php
include_once "assets/conf/default.inc.php";
require_once "assets/conf/Conexao.php";
$pdo = Conexao::getInstance();

// $menu = isset($_POST['menu']) ? $_POST['menu'] : false;

$arquivo = file_get_contents('table.json');
$tabela = json_decode($arquivo);
if ($tabela == '') {
  header("location:index.php");
}
// if ($menu == true) {
//   header("location:index.php");
// }

$acao = isset($_POST['acao']) ? $_POST['acao'] : '';


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
  // echo "<br>Cont: ".$cont;
  $contador=0;
  $acao = isset($_POST['acao']) ? $_POST['acao'] : '';
  if ($acao=="ADICIONAR") {
    for ($i=0; $i < count($inputs) ; $i++) {
      if ($_POST["novo_{$inputs[$i]}"]) {
        $contador++;
        
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
      // echo "<br>";
      // var_dump($sql);
    }
    $sql->execute();
  }elseif ($acao=="ALTERAR") {
    for ($i=0; $i < count($inputs) ; $i++) {
      if ($_POST["novo_{$inputs[$i]}"]) {
        $contador++;
      }
    }
    // echo "<br>Contador: ".$contador;
    if ($contador == $cont) {
      $camposBind = array();
      for ($v=0; $v < count($inputs) ; $v++) {
        $camposBind[] = ":".$inputs[$v];
      }
      // echo "<br>";
      // var_dump($camposBind);
      $comando = "update {$tabela} set ";
      for ($i=0; $i < count($inputs) ; $i++) {
        if ($i != 0) {
          $comando .= ", ";
        }
        $comando .= "{$inputs[$i]} = :".$inputs[$i];
      }
      $comando .= " WHERE codigo = :codigo;";
      // echo "<br>";
      // var_dump($comando);
      $sql_novo = $GLOBALS['pdo']->prepare($comando);
      $sql_novo->bindParam(":codigo", $_POST["codigo"]);
      // echo "<br>:codigo = ".$_POST['codigo'];
      for ($x=0; $x < count($inputs) ; $x++) {
        $sql_novo->bindParam(":{$inputs[$x]}", $_POST["novo_{$inputs[$x]}"]);
        // echo "<br>:{$inputs[$x]} = ".$_POST["novo_{$inputs[$x]}"];
      }
      // echo "<br>";
      // var_dump($sql_novo);
    }
    $sql_novo->execute();
    header("location: tabela.php");
  }
}

function apresentaFormulario($tabela){
  echo "<fieldset>";
  echo "<form action='' method='post' border='1px'>";
  echo "ADICIONAR REGISTRO <br><br>";
  $field = $GLOBALS['pdo']->query("SHOW COLUMNS FROM {$tabela};");
  $alterar = isset($_GET['alterar']) ? $_GET['alterar'] : '';
  if ($alterar == 'ALTERAR') {
    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';
    $field_novo = $GLOBALS['pdo']->query("SELECT * FROM {$tabela} WHERE codigo = {$codigo};");
    $valores = array();
    while ($linha = $field_novo->fetch(PDO::FETCH_ASSOC)) {
      $valores = $linha;
    }
    // var_dump($valores);
    // echo "<br>";
  }
      if ($alterar == "ALTERAR") {
        echo "Código: <input readonly type='number' name='codigo' value='{$codigo}'><br>";
      }
  while ($linha = $field->fetch(PDO::FETCH_ASSOC)) {
    // echo substr($linha['Type'], 0, 5). "<br><Br>";
    if ($linha['Key'] != 'PRI') {
      echo $linha['Field'];
      //$inputs = "novo_".$linha['Field'];
      if ($linha['Type'] == 'date') {
        ?>
        <input required type="date" name="novo_<?php echo $linha['Field']; ?>" value="<?php if ($alterar =='ALTERAR') {
          echo $valores[$linha['Field']];
        } ?>"> <br>
        <?php
      }else if (substr($linha['Type'], 0, 3) == 'int') {
        ?>
        <input required type="number" name="novo_<?php echo $linha['Field']; ?>" value="<?php if ($alterar =='ALTERAR') {
          echo $valores[$linha['Field']];
        } ?>"> <br>
        <?php
      }else {
        ?>
        <input required type="text" name="novo_<?php echo $linha['Field']; ?>" value="<?php if ($alterar =='ALTERAR') {
          echo $valores[$linha['Field']];
        } ?>"> <br>
        <?php
      }
    }
    ?>
    <input type="hidden" name="tabela" value="<?php echo $tabela; ?>">
    <?php
    // $linha['Field']
  }
  echo "<br>";
  echo "<input type='submit' name='acao' value='";
  if ($alterar == 'ALTERAR') {
    echo "ALTERAR";
  }else{
    echo "ADICIONAR";
  }
  echo"'>";
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
    echo "<th>Alterar</th>";
    echo "<th>Excluir</th>";
    echo "</tr>";
    $count = 0;
    while ($linha = $conexao->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      for ($i=0; $i < count($colunas) ; $i++) {
        echo "<td>{$linha[$colunas[$i]]}</td>";
      }
      echo "<td>";
      ?>
      <a href="tabela.php?alterar=ALTERAR&tabela=
      <?php echo $tabela; ?>
      &codigo=<?php echo $linha['codigo'];?>">Alterar</a>

      <?php
      echo "</td>";
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
