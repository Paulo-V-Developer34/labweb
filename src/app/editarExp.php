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

        if(isset($_POST["btnEditarExpModal"])){
        
            $sql = $conecta->prepare("UPDATE experimentos SET dataExperimento=?, dataValidadeExperimento=?, peso=?, volume=?, presencaSM=?, temperaturaLote=?, ph=?, condicaoExperimento=?, obsExperimento=?, matriculaTecnico=? WHERE numeroLote=? ");
            $sql->bindParam(1,$dataExprimento);
            $sql->bindParam(2,$dataValidade);
            $sql->bindParam(3,$peso);
            $sql->bindParam(4,$volume);
            $sql->bindParam(5,$salmoura);
            $sql->bindParam(6,$temperatura);
            $sql->bindParam(7,$ph);
            $sql->bindParam(8,$condicao);
            $sql->bindParam(9,$obsAmostra);
            $sql->bindParam(10,$matriculaTecExp);
            $sql->bindParam(11,$numeroLote);
            $sql->execute();

            //Retorna para a Pagina de Técnicos
            header('location:paginaInicial.php');
        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    
    }catch(PDOException $e){
        echo "falha ao conectar: ". $e->getMessage();
    }   

?>