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
       <a href="index.php">RETORNAR AO MENU</a>
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
