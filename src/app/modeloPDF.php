<?php
function html($numeroLote) { 
    //fazer conexão com o BD
    include_once 'conexaoBD.php'; //

    //criando a instância --- talvez isso seja desnecessário com o PDO  
    try{
    $sql = "CALL dadosExperimento($numeroLote)"; // eu devo trocar o número "1" por outro valor na hora que eu for implementar no BD real

    $resultado = $conecta->query($sql);
    //transferir os dados da query (procedure) para variáveis.
    if ($resultado != 0) {

        $linha = $resultado->fetch(PDO::FETCH_ASSOC); //posso tentar usar um extract depois do "fetch(PDO::FETCH_ASSOC);"
        $numeroLote = $linha['numeroLote']; 
        $dataExperimento = $linha['dataExperimento']; 
        $dataValidadeExperimento = $linha['dataValidadeExperimento']; 
        $peso = $linha['peso'];
        $volume = $linha['volume'];                                 // FALTA UMA COLUNA NOME PARA O EXPERIMENTO!
        $presencaSM = $linha['presencaSM'];
        $temperaturaLote = $linha['temperaturaLote'];
        $ph = $linha['ph'];
        $condicaoExperimento = $linha['condicaoExperimento'];
        $obsExperimento = $linha['obsExperimento'];
        $matriculaTecnico = $linha['matriculaTecnico'];
        $nome = $linha['nome'];
        $registro = $linha['registro']; //não sei se eu uso isso em algum lugar
    }
    }catch(PDOException $e){
        echo "Falha ao conectar: ". $e->getMessage();
    }

    $dataExperimento = date("d/m/Y",strtotime($dataExperimento));
    $dataValidadeExperimento = date("d/m/Y",strtotime($dataValidadeExperimento));

    if ($presencaSM == 1) {
        $presencaSM = 'sim';
    } else {
        $presencaSM = 'não';
    }

    $html =
    "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Document</title>
        <link rel='stylesheet' href='http://localhost/TCC_ETEC_Rev2/TCC_ETEC/css/stylePDF.css'>
    </head>
    <header>
        <table class='semborda'>
            <tr>
                <td class='pequeno semborda'><img src='http://localhost/TCC_ETEC_Rev2/TCC_ETEC/img/logo_labweb.png'></td>
                <td class='muito_grande semborda'><h2>LabWeb<br/>
                Relatório de Ensaio Lote n°{$numeroLote}
                </h2></td>
            </tr>
        </table>
    </header>
    <body>
    <!--dados do experimento --- usei as {} para colocar o valor das variáveis, OBS: só funciona com aspas duplas-->
        
        <table>
            <tr>
                <td class='maximo titulo'>ID do lote: {$numeroLote}</td>
            </tr>
        </table>

        <table>
            <tr>
                <td class='grande'>Data da realização do experimento: {$dataExperimento}</td>
                <td class='grande_fim'>Data de validade do experimento: {$dataValidadeExperimento}</td>
            </tr>
        </table>

        <table>
            <tr>
                <td class='medio'>Peso: {$peso}kg</td>
                <td class='medio'>Volume: {$volume}m³</td>
                <td rowspan='2' class='medio'>Presença de Salmoura: {$presencaSM}</td>
            </tr>
            <tr>
                <td>PH: {$ph}</td>
                <td>Temperatura do lote: {$temperaturaLote}k</td>
            </tr>
        </table>

        <table>
            <tr>
                <td class='maximo titulo'>Condição do experimento</td>
            </tr>

            <tr>
                <td>{$condicaoExperimento}</td>
            </tr>
        </table>

        <table>
            <tr>
                <td class='maximo titulo'>Observações</td>
            </tr>

            <tr>
                <td class='muito_alto'>{$obsExperimento}</td>
            </tr>
        </table>

        <table>
            <tr>
                <td class='grande_fim'>Nome do técnico: {$nome}</td>
                <td class='grande'>Matricula do técnico: {$matriculaTecnico}</td>
            </tr>
        </table>

        <table>
            <tr>
                <td class='maximo titulo'>Assinatura</td>
            </tr>

            <tr>
                <td class='baixo'></td>
            </tr>
        </table>

    </body>
    </html>";
    return $html;
}

?>