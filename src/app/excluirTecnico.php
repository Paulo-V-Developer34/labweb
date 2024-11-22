<?php
    // Inclui o arquivo que verifica o acesso do usuario
    require_once ('verificarAcesso.php');  
    // Carrega o arquivo de conexão ao BD
    require_once ('conexaoBD.php');

    try{

        // Coletando os dados do Formulario de Cadastro via POST
        $nome = $_POST['nomeTecExcluir'];
        $cpf = $_POST['cpfTecExcluir'];
        $matricula = $_POST['matriculaTecExcluir'];

        if(isset($_POST["btnExcluirTecModal"])){

            //echo $nome;
        
            $sql = "DELETE FROM tecnicos WHERE matricula =".$matricula; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            $stmt = $conecta->prepare($sql);
            $stmt->execute();

            $sql1 = "DELETE FROM pessoas WHERE cpf =".$cpf; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            $stmt1 = $conecta->prepare($sql1);
            $stmt1->execute();
            
            header ('Location: paginaTecnicos.php');

        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>