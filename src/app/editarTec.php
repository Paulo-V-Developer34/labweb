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
        
        $matriculaTec = $_POST['matriculaTec'];
        $registroTec = $_POST['registroTec'];
        $dataAdmissaoTec = $_POST['dataAdmissaoTec'];
        $dataRecisaoTec = $_POST['dataRecisaoTec'];
        $cargoTec = $_POST['cargoTec'];

        If($_POST['statusTec'] == 1){
            $statusTec = 1;
        }else{
            $statusTec = 0;
        }

        if(isset($_POST["btnEditarTecModal"])){
        
            $sql = $conecta->prepare("UPDATE pessoas SET nome=?, telefoneCelular=?, telefoneFixo=?, email=?, rua=?, bairro=?, cidade=?, estado=? WHERE cpf=? ");
            $sql->bindParam(1,$nome);
            $sql->bindParam(2,$celularTec);
            $sql->bindParam(3,$telefoneFixoTec);
            $sql->bindParam(4,$email);
            $sql->bindParam(5,$ruaTec);
            $sql->bindParam(6,$bairroTec);
            $sql->bindParam(7,$cidadeTec);
            $sql->bindParam(8,$estadoTec);
            $sql->bindParam(9,$cpf);
            $sql->execute();

            $sql_1 = $conecta->prepare("UPDATE tecnicos SET registro=?, dataAdmissao=?, cargo=?, statusTecnico=? WHERE matricula=? ");
            $sql_1->bindParam(1,$registroTec);
            $sql_1->bindParam(2,$dataAdmissaoTec);
            $sql_1->bindParam(3,$cargoTec);
            $sql_1->bindParam(4,$statusTec);
            $sql_1->bindParam(5,$matriculaTec);
            $sql_1->execute();
            //Retorna para a Pagina de Técnicos
            header('location:paginaTecnicos.php');
        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>