<?php
$arquivo = file_get_contents('tela.json');
$ativa = json_decode($arquivo);

function verificaCor($hexa){
    $r = hexdec(substr($hexa,1,2)); // Se for sem o #, mude para 0, 2
    $g = hexdec(substr($hexa,3,2)); // Se for sem o #, mude para 3, 2
    $b = hexdec(substr($hexa,5,2)); // Se for sem o #, mude para 5, 2
    $luminosidade = ( $r * 299 + $g * 587 + $b * 114) / 1000;
    if( $luminosidade > 128 ) {
        // echo 'Cor clara';
        $res = true;
     } else {
        // echo 'Cor escura';
        $res = false;
     }
     return $res;
}

function apresentaNotas($consulta){
    $ativa = $GLOBALS['ativa'];
    ?>
    <div class="row container">
    <?php
    $cont=1;
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        if (verificaCor($linha['cor_fundo'])) {
            $cor = '#000000';
        }else {
            $cor = '#ffffff';
        }
    ?>
            <div class="col l3">
                <div class="card" style="background-color: <?php echo $linha['cor_fundo']; ?>;">
                    <div class="card-content" style="color: <?php echo $cor; ?>;">
                    <span class="card-title" style="font-weight: 600;"><?php 
                        if ($linha['star'] == 1) {
                            echo "<i class='material-icons'>star</i> ";
                            }
                        echo $linha['titulo'];?>
                    </span>
                    <p><?php echo $linha['texto'];?></p>
                    <br>
                    <hr style="border-color: <?php echo $cor; ?>">
                    <p><?php echo $linha['tags'];?></p>
                    </div>
                    <div class="card-action center">
                    <?php if ($ativa == 0) {
                        // echo "ATIVAS";
                        ?>
                        <a href="javascript:recuperarRegistro('acao.php?acao=recuperar&codigo=<?php echo $linha['codigo'];?>')" style="color: <?php echo $cor; ?>;font-weight: 800;">RECUPERAR</a>
                        <?php
                    }else {
                        // echo "EXCLUÍDAS";
                        ?>
                        <a href='cad.php?acao=editar&codigo=<?php echo $linha['codigo'];?>' style="color: <?php echo $cor; ?>;font-weight: 800;">ALTERAR</a>
                        <a href="javascript:excluirRegistro('acao.php?acao=excluir&codigo=<?php echo $linha['codigo'];?>')" style="color: <?php echo $cor; ?>;font-weight: 800;">EXCLUIR</a>
                        <?php
                    } ?>
                    </div>
                </div>
            </div>
        <?php
        if ($cont%4==0) {
            ?>
            </div>
            <div class="row container">
            <?php 
            $ok = true;
         }
         $cont++;
        }
        ?>
        </div>
        <?php
}

function obtemSQL(){
    $ativa = $GLOBALS['ativa'];
    $consulta = isset($_GET['consulta']) ? $_GET['consulta'] : "";
    $opcao = isset($_GET['opcao']) ? $_GET['opcao'] : "";
    $estrela = isset($_GET['estrela']) ? $_GET['estrela'] : "";
    $pdo = Conexao::getInstance();
    if ($consulta != "") {
        if ($opcao == "texto") {
            if ($estrela == 0) {
                $sql = "SELECT * from anotacoes where (titulo like '%$consulta%' or texto like '%$consulta%') and ativa = $ativa";
            }
            else {
                $sql = "SELECT * from anotacoes where (titulo like '%$consulta%' or texto like '%$consulta%') and star = $estrela and ativa = $ativa;";
            }
        }else {
            if ($estrela == 0) {
                $sql = "SELECT * from anotacoes where tags like '%$consulta%' and ativa = $ativa";
            }
            else {
                $sql = "SELECT * from anotacoes where tags like '%$consulta%' and star = $estrela and ativa = $ativa";
            }
        }
    }elseif ($consulta == "" and $estrela == 1) {
        $sql = "SELECT * from anotacoes where star = $estrela and ativa = $ativa";
    }
    else {
        $sql = "SELECT * from anotacoes where ativa = $ativa;";
    }
    $consulta = $pdo->query($sql);
    return $consulta;
}

function apresentaNotasTabela($consulta){
    $ativa = $GLOBALS['ativa'];
    ?>
    <table>
    <tr>
        <th>Código</th>
        <th>Título</th>
        <th>Texto</th>
        <th>Tags</th>
        <th>Ação</th>
    </tr>
    <?php
    $cont=1;
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        if (verificaCor($linha['cor_fundo'])) {
            $cor = '#000000';
        }else {
            $cor = '#ffffff';
        }
        ?>
        <tr style="background-color: <?php echo $linha['cor_fundo']; ?>; color: <?php echo $cor; ?>;">
        <td>
        <?php echo $linha['codigo']; ?>
        </td>
        <td>
        <?php 
            if ($linha['star'] == 1) {
                echo "<i class='material-icons'>star</i> ";
            }
            echo $linha['titulo'];?>
        </td>
        <td>
            <p><?php echo $linha['texto'];?></p>
        </td>
        <td>
            <p><?php echo $linha['tags'];?></p>
        </td>
        <td>
            <?php if ($ativa == 0) {
            // echo "ATIVAS";
            ?>
                <a href="javascript:recuperarRegistro('acao.php?acao=recuperar&codigo=<?php echo $linha['codigo'];?>')" style="color: <?php echo $cor; ?>;font-weight: 800;">RECUPERAR</a>
                <?php
            }else {
                // echo "EXCLUÍDAS";
                ?>
                <a href='cad.php?acao=editar&codigo=<?php echo $linha['codigo'];?>' style="color: <?php echo $cor; ?>;font-weight: 800;">ALTERAR</a>
                <a href="javascript:excluirRegistro('acao.php?acao=excluir&codigo=<?php echo $linha['codigo'];?>')" style="color: <?php echo $cor; ?>;font-weight: 800;">EXCLUIR</a>
                <?php
            } ?>
        </td>
        
        
        </tr>
        <?php
    }
        ?>
        </table>
        <?php
}

function apresentaNotasCards($consulta){
    $ativa = $GLOBALS['ativa'];
    ?>
    <div class="row container">
    <?php
    $cont=1;
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        if (verificaCor($linha['cor_fundo'])) {
            $cor = '#000000';
        }else {
            $cor = '#ffffff';
        }
    ?>
            <div class="col l3">
                <div class="card" style="border-radius: 15px;background-color: <?php echo $linha['cor_fundo'];?>;color: <?php echo $cor; ?>;">
                    <div class="card-content">
                    <div class="card-title">
                        <span style="font-weight: 600;"><?php 
                            if ($linha['star'] == 1) {
                                echo "<i class='material-icons'>star</i> ";
                            }
                            echo $linha['titulo'];?>
                        </span>
                            </div>
                        <?php echo $linha['texto'];?>
                        <br><br>
                        <hr style="border-color: <?php echo $cor; ?>;">
                        <?php echo $linha['tags'];?>
                    </div>
                    <div class="card-action center" style="border-radius: 15px;">
                    <?php if ($ativa == 0) {
                        // echo "ATIVAS";
                        ?>
                        <a href="javascript:recuperarRegistro('acao.php?acao=recuperar&codigo=<?php echo $linha['codigo'];?>')" style="color: <?php echo $cor; ?>;font-weight: 800;">RECUPERAR</a>
                        <?php
                    }else {
                        // echo "EXCLUÍDAS";
                        ?>
                        <a href='cad.php?acao=editar&codigo=<?php echo $linha['codigo'];?>' style="color: <?php echo $cor; ?>;font-weight: 800;">ALTERAR</a>
                        <a href="javascript:excluirRegistro('acao.php?acao=excluir&codigo=<?php echo $linha['codigo'];?>')" style="color: <?php echo $cor; ?>;font-weight: 800;">EXCLUIR</a>
                        <?php
                    } ?>
                    </div>
                </div>
            </div>
        <?php
        if ($cont%4==0) {
            ?>
            </div>
            <div class="row container">
            <?php 
            $ok = true;
         }
         $cont++;
        }
        ?>
        </div>
        <?php
}


?>