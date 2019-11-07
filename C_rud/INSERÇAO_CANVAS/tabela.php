<?php
  include("funcoes.php");
  recebeFormulario($tabela);
 ?>
 <!DOCTYPE html>
 <html lang="pt-br">
   <head>
     <meta charset="utf-8">
     <title>INSERIR - <?php echo strtoupper($tabela); ?></title>
   </head>
   <body>
     <form class="" action="" method="post">
       <button type="submit" name="menu" value="true">RETORNAR AO MENU</button>
       <center>
         <?php
         echo "<h2>TABELA ".strtoupper($tabela)."</h2>";

         apresentaFormulario($tabela);
         $sql = $pdo->query("SELECT * from {$tabela};");
         apresentaTabela($sql, $tabela);
          ?>
       </center>
     </form>
   </body>
 </html>
