<?php
    // Inclui o arquivo que verifica o acesso do usuario
    require_once ('verificarAcesso.php');  
    // Carrega o arquivo de conexão ao BD
    require_once ('conexaoBD.php');

    try{

        // Coletando os dados do Formulario de Cadastro via POST
        $nome = $_POST['nomeADM'];
        $cpf = $_POST['cpfADM'];
        $email = $_POST['emailADM'];
        $celularADM = $_POST['celularADM'];
        $telefoneFixoADM = $_POST['telefoneFixoADM'];
        $ruaADM = $_POST['ruaADM'];
        $bairroADM = $_POST['bairroADM'];
        $cidadeADM = $_POST['cidadeADM'];
        $estadoADM = $_POST['estadoADM'];
        $senha_hashed = hash('sha256',$_POST['senhaADM']); //Senha criptografada via função hash
        $cargoADM = $_POST['cargoADM'];
        $dataAdmissaoADM = $_POST['dataAdmissaoADM'];

        $senhaADM = $_POST['senhaADM'];
        $confirmaSenhaADM = $_POST['confirmaSenhaADM'];

        if(isset($_POST["btnCadastrarADM"])){
        
            $sql = "SELECT * FROM pessoas WHERE cpf =".$cpf; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            $resultado = $conecta->query($sql);
            if($resultado -> rowCount() == 1){
                header ('Location: paginaAdministradores.php'); // caso encontre o cpf ja cadastrado retorna para Página de Técnicos
            }else{
                // Monta o SQL para inserir os dados pessoais na Tabela Pessoas
                $sql_1 = "INSERT INTO pessoas (cpf, nome, telefoneCelular, telefoneFixo, email, rua, bairro, cidade, estado, senha, tipo_usuario) 
                VALUES ('".$cpf."', '".$nome."', '".$celularADM."', '".$telefoneFixoADM."', '".$email."', '".$ruaADM."', '".$bairroADM."', '".$cidadeADM."', '".$estadoADM."', '".$senha_hashed."', '1')";

                $resultado_1 = $conecta->query($sql_1);

                // Monta o SQL para inserir os dados pessoais na Tabela Pessoas
                $sql_2 = "INSERT INTO administradores (cargo, dataAdmissao, statusAdministrador, cpf) 
                VALUES ('".$cargoADM."', '".$dataAdmissaoADM."', '1', '".$cpf."')";
        
                $resultado_2 = $conecta->query($sql_2);

                //Retorna para a Pagina de Técnicos
                header('location:paginaAdministradores.php');
            }
        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>