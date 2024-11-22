<?php
    // Inclui o arquivo que verifica o acesso do usuario
    require_once ('verificarAcesso.php');  
    // Carrega o arquivo de conexão ao BD
    require_once ('conexaoBD.php');

    try{

        // Coletando os dados do Formulario de Cadastro via POST
        $nome = $_POST['nomeClienteExcluir'];
        $cpf = $_POST['cpfClienteExcluir'];
        $numero = $_POST['numeroClienteExcluir'];

        if(isset($_POST["btnExcluirClienteModal"])){

            //echo $nome;
        
            $sql = "DELETE FROM clientes WHERE numero =".$numero; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            $stmt = $conecta->prepare($sql);
            $stmt->execute();

            $sql1 = "DELETE FROM pessoas WHERE cpf =".$cpf; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            $stmt1 = $conecta->prepare($sql1);
            $stmt1->execute();
            
            header ('Location: paginaClientes.php');

        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>