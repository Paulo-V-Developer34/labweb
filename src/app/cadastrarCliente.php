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
        $senha_hashed = hash('sha256',$_POST['senhaCliente']); //Senha criptografada via função hash
        $empresaCliente = $_POST['empresaCliente'];

        $senhaCliente = $_POST['senhaCliente'];
        $confirmaSenhaCliente = $_POST['confirmaSenhaCliente'];

        if(isset($_POST["btnCadastrarCliente"])){
        
            $sql = "SELECT * FROM pessoas WHERE cpf =".$cpf; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            $resultado = $conecta->query($sql);
            if($resultado -> rowCount() == 1){
                header ('Location: paginaClientes.php'); // caso encontre o cpf ja cadastrado retorna para Página de Clientes
            }else{
                // Monta o SQL para inserir os dados pessoais na Tabela Pessoas
                $sql_1 = "INSERT INTO pessoas (cpf, nome, telefoneCelular,telefoneFixo, email, rua, bairro, cidade, estado, senha, tipo_usuario) 
                VALUES ('".$cpf."', '".$nome."', '".$celularCliente."', '".$telefoneFixoCliente."', '".$email."', '".$ruaCliente."', '".$bairroCliente."', '".$cidadeCliente."', '".$estadoCliente."', '".$senha_hashed."', '3')";

                $resultado_1 = $conecta->query($sql_1);

                // Monta o SQL para inserir os dados pessoais na Tabela Clientes
                $sql_2 = "INSERT INTO clientes (empresa, statusUsuarios, cpf) 
                VALUES ('".$empresaCliente."', '1', '".$cpf."')";
        
                $resultado_2 = $conecta->query($sql_2);

                //Retorna para a Pagina de Técnicos
                header('location:paginaClientes.php');
            }
        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>