<?php

    include_once "conf/default.inc.php";
    require_once "conf/Conexao.php";

    // Se foi enviado via GET para acao entra aqui
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    if ($acao == "excluir"){
        $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : 0;
        excluir($codigo);
    }elseif ($acao == "recuperar"){
        $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : 0;
        recuperar($codigo);
    }elseif ($acao=="ativa") {
        $arquivo = file_get_contents('tela.json');
        $opcao = json_decode($arquivo);
        if ($opcao == 0) {
            $dados_json = json_encode("1");
            $fp = fopen("tela.json", "w");
            $escreve = fwrite($fp, $dados_json);
            fclose($fp);
        }else {
            $dados_json = json_encode("0");
            $fp = fopen("tela.json", "w");
            $escreve = fwrite($fp, $dados_json);
            fclose($fp);
        }
        header("location:index.php");
    }

    // Se foi enviado via POST para acao entra aqui
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
    if ($acao == "salvar"){
        $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : "";
        if ($codigo == 0)
            inserir($codigo);
        else
            editar($codigo);
    }

    // Métodos para cada operação
    function inserir($codigo){
        $dados = dadosForm();
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('INSERT INTO anotacoes (titulo, texto, cor_fundo, tags, ativa, star) VALUES(:titulo, :texto, :cor_fundo, :tags, :ativa, :star)');
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':texto', $texto, PDO::PARAM_STR);
        $stmt->bindParam(':cor_fundo', $cor_fundo, PDO::PARAM_STR);
        $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
        $stmt->bindParam(':ativa', $ativa, PDO::PARAM_STR);
        $stmt->bindParam(':star', $star, PDO::PARAM_STR);
        $titulo = $dados['titulo'];
        $texto = $dados['texto'];
        $cor_fundo = $dados['cor_fundo'];
        $tags = $dados['tags'];
        $ativa = 1;
        $star = $dados['star'];
        $stmt->execute();
        header("location:cad.php");
    }

    function editar($codigo){
        $dados = dadosForm();
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE anotacoes SET titulo = :titulo, texto = :texto, cor_fundo = :cor_fundo, tags = :tags, ativa = :ativa, star = :star WHERE codigo = :codigo');
        $codigo = $dados['codigo'];
        $titulo = $dados['titulo'];
        $texto = $dados['texto'];
        $cor_fundo = $dados['cor_fundo'];
        $tags = $dados['tags'];
        $ativa = 1;
        $star = $dados['star'];
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':texto', $texto, PDO::PARAM_STR);
        $stmt->bindParam(':cor_fundo', $cor_fundo, PDO::PARAM_STR);
        $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
        $stmt->bindParam(':ativa', $ativa, PDO::PARAM_INT);
        $stmt->bindParam(':star', $star, PDO::PARAM_INT);
        $stmt->execute();
        header("location:index.php?consulta=");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $ativa = 0;
        $stmt = $pdo->prepare('UPDATE anotacoes SET ativa = :ativa WHERE codigo = :codigo;');
        $stmt->bindParam(':ativa', $ativa, PDO::PARAM_INT);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        header("location:index.php");
    }

    function recuperar($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE anotacoes SET ativa = :ativa WHERE codigo = :codigo;');
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $ativa = 1;
        $stmt->bindParam(':ativa', $ativa, PDO::PARAM_INT);
        $stmt->execute();
        header("location:index.php");
    }


    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT * FROM anotacoes WHERE codigo = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['codigo'] = $linha['codigo'];
            $dados['titulo'] = $linha['titulo'];
            $dados['texto'] = $linha['texto'];
            $dados['cor_fundo'] = $linha['cor_fundo'];
            $dados['tags'] = $linha['tags'];
            $dados['ativa'] = $linha['ativa'];
            $dados['star'] = $linha['star'];
        }
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['codigo'] = $_POST['codigo'];
        $dados['titulo'] = $_POST['titulo'];
        $dados['texto'] = $_POST['texto'];
        $dados['cor_fundo'] = $_POST['cor_fundo'];
        $dados['tags'] = $_POST['tags'];
        $dados['ativa'] = $_POST['ativa'];
        $dados['star'] = $_POST['star'];
        return $dados;
    }

?>