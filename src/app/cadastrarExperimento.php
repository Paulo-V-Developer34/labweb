
<?php
    // Inclui o arquivo que verifica o acesso do usuario
    require_once ('verificarAcesso.php');  
    // Carrega o arquivo de conexão ao BD
    require_once ('conexaoBD.php');

    try{

        // Coletando os dados do Formulario de Cadastro via POST
        $nomeTecExp = $_POST['nomeTecExp'];
        $matriculaTecExp = $_POST['matriculaTecExp'];
        $registroTecExp = $_POST['registroTecExp'];
        $numeroLote = $_POST['inputLote'];
        $dataExprimento = $_POST['dataExperimento'];
        $dataValidade = $_POST['dataValidadeExperimento'];
        $peso = $_POST['pesoAmostra'];
        $volume = $_POST['volumeAmostra'];
        $ph = $_POST['phAmostra'];
        $temperatura = $_POST['temperaturaAmostra'];
        $presencaSalmoura = $_POST['smAmostra'];
        if($presencaSalmoura == null){
            $salmoura = '0';
        }else{
            $salmoura = '1';
        }
        $condicao = $_POST['condicaoExp'];
        $obsAmostra = $_POST['obsAmostra'];

        if(isset($_POST["btnCadastrarExperimento"])){
        
            $sql = "SELECT * FROM experimentos WHERE numeroLote =".$numeroLote; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            $resultado = $conecta->query($sql);
            if($resultado -> rowCount() == 1){
                header ('Location: paginaInicial.php'); // caso encontre o cpf ja cadastrado retorna para Página de Clientes
            }else{
                // Monta o SQL para inserir os dados pessoais na Tabela Pessoas
                $sql_1 = "INSERT INTO experimentos (numeroLote, dataExperimento, dataValidadeExperimento, peso, volume, presencaSM, temperaturaLote, ph, condicaoExperimento, obsExperimento, matriculaTecnico)
                VALUES ('".$numeroLote."', '".$dataExprimento."', '".$dataValidade."', '".$peso."', '".$volume."', '".$salmoura."', '".$temperatura."', '".$ph."', '".$condicao."', '".$obsAmostra."', '".$matriculaTecExp."')";

                $resultado_1 = $conecta->query($sql_1);

                //Retorna para a Pagina de Técnicos
                header('location:paginaInicial.php');
            }
        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>