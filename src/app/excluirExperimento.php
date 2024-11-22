<?php
    // Inclui o arquivo que verifica o acesso do usuario
    require_once ('verificarAcesso.php');  
    // Carrega o arquivo de conexão ao BD
    require_once ('conexaoBD.php');

    try{

        // Coletando os dados do Formulario de Cadastro via POST
        $numeroLote = $_POST['numeroLote'];

        if(isset($_POST["btnExcluirExpModal"])){
        
            $sql = "DELETE FROM experimentos WHERE numeroLote =".$numeroLote; 
            $stmt = $conecta->prepare($sql);
            $stmt->execute();

            header ('Location: paginaInicial.php');

        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>