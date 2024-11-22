<?php
    // Inclui o arquivo que verifica o acesso do usuario
    require_once ('verificarAcesso.php');  
    // Carrega o arquivo de conexão ao BD
    require_once ('conexaoBD.php');

    try{

        // Coletando os dados do Formulario de Cadastro via POST
        $nome = $_POST['nomeCliente'];
        $cpf = $_POST['cpfCliente'];
        $email = $_POST['emailCliente'];
        $celularCliente = $_POST['celularCliente'];
        $telefoneFixoCliente = $_POST['telefoneFixoCliente'];
        $ruaCliente = $_POST['ruaCliente'];
        $bairroCliente = $_POST['bairroCliente'];
        $cidadeCliente = $_POST['cidadeCliente'];
        $estadoCliente = $_POST['estadoCliente'];

        $numeroCliente = $_POST['numeroCliente'];
        $empresaCliente = $_POST['empresaCliente'];

        If($_POST['statusCliente'] == 1){
            $statusCliente = 1;
        }else{
            $statusCliente = 0;
        }

        if(isset($_POST["btnEditarClienteModal"])){
        
            $sql = $conecta->prepare("UPDATE pessoas SET nome=?, telefoneCelular=?, telefoneFixo=?, email=?, rua=?, bairro=?, cidade=?, estado=? WHERE cpf=? ");
            $sql->bindParam(1,$nome);
            $sql->bindParam(2,$celularCliente);
            $sql->bindParam(3,$telefoneFixoCliente);
            $sql->bindParam(4,$email);
            $sql->bindParam(5,$ruaCliente);
            $sql->bindParam(6,$bairroCliente);
            $sql->bindParam(7,$cidadeCliente);
            $sql->bindParam(8,$estadoCliente);
            $sql->bindParam(9,$cpf);
            $sql->execute();

            $sql_1 = $conecta->prepare("UPDATE clientes SET empresa=?, statusUsuarios=? WHERE numero=? ");
            $sql_1->bindParam(1,$empresaCliente);
            $sql_1->bindParam(2,$statusCliente);
            $sql_1->bindParam(3,$numeroCliente);
            $sql_1->execute();
            //Retorna para a Pagina de Técnicos
            header('location:paginaClientes.php');
        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>