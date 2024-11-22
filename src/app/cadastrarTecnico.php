<?php
    // Inclui o arquivo que verifica o acesso do usuario
    require_once ('verificarAcesso.php');  
    // Carrega o arquivo de conexão ao BD
    require_once ('conexaoBD.php');

    try{

        // Coletando os dados do Formulario de Cadastro via POST
        $nome = $_POST['nomeTec'];
        $cpf = $_POST['cpfTec'];
        $email = $_POST['emailTec'];
        $celularTec = $_POST['celularTec'];
        $telefoneFixoTec = $_POST['telefoneFixoTec'];
        $ruaTec = $_POST['ruaTec'];
        $bairroTec = $_POST['bairroTec'];
        $cidadeTec = $_POST['cidadeTec'];
        $estadoTec = $_POST['estadoTec'];
        $senha_hashed = hash('sha256',$_POST['senhaTec']); //Senha criptografada via função hash
        $registroTec = $_POST['registroTec'];
        $cargoTec = $_POST['cargoTec'];
        $dataAdmissaoTec = $_POST['dataAdmissaoTec'];

        $senhaTec = $_POST['senhaTec'];
        $confirmaSenhaTec = $_POST['confirmaSenhaTec'];

        if(isset($_POST["btnCadastrarTec"])){
        
            $sql = "SELECT * FROM pessoas WHERE cpf =".$cpf; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            $resultado = $conecta->query($sql);
            if($resultado -> rowCount() == 1){
                header ('Location: paginaTecnicos.php'); // caso encontre o cpf ja cadastrado retorna para Página de Técnicos
            }else{
                // Monta o SQL para inserir os dados pessoais na Tabela Pessoas
                $sql_1 = "INSERT INTO pessoas (cpf, nome, telefoneCelular, telefoneFixo, email, rua, bairro, cidade, estado, senha, tipo_usuario) 
                VALUES ('".$cpf."', '".$nome."', '".$celularTec."', '".$$telefoneFixoTec."', '".$email."', '".$ruaTec."', '".$bairroTec."', '".$cidadeTec."', '".$estadoTec."', '".$senha_hashed."', '2')";

                $resultado_1 = $conecta->query($sql_1);

                // Monta o SQL para inserir os dados pessoais na Tabela Pessoas
                $sql_2 = "INSERT INTO tecnicos (cargo, registro, dataAdmissao, statusTecnico, cpf) 
                VALUES ('".$cargoTec."', '".$registroTec."', '".$dataAdmissaoTec."', '1', '".$cpf."')";
        
                $resultado_2 = $conecta->query($sql_2);

                //Retorna para a Pagina de Técnicos
                header('location:paginaTecnicos.php');
            }
        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>