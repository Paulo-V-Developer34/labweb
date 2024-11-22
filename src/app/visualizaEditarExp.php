<?php
        // Inclui o arquivo que verifica o acesso do usuario
        require_once ('verificarAcesso.php');
        
        if(isset($_POST["numeroLote"])){

            // Carrega o arquivo de conexão ao BD
            require_once ('conexaoBD.php');

            $sql = "SELECT * FROM experimentos WHERE numeroLote = ".$_POST["numeroLote"];
            $resultado = $conecta->query($sql); 

            if($resultado != null)
                foreach($resultado as $linha) {
                            // Coletando os dados do Formulario de Cadastro via POST
                    $numeroLote = $linha['numeroLote'];
                    $matriculaTec = $linha['matriculaTecnico'];
                    $dataExperimento = $linha['dataExperimento'];
                    $dataValidadeExperimento = $linha['dataValidadeExperimento'];
                    $peso = $linha['peso'];
                    $volume = $linha['volume'];
                    $presencaSM = $linha['presencaSM'];
                    if($presencaSM == null){
                        $salmoura = '0';
                    }else{
                        $salmoura = $presencaSM;
                    }
                    $temperatura = $linha['temperaturaLote'];
                    $ph = $linha['ph'];
                    $condicaoExperimento = $linha['condicaoExperimento'];
                    $obsExperimento = $linha['obsExperimento'];
                       
                }

            
            $sql_1 = "SELECT * FROM tecnicos WHERE matricula = ".$matriculaTec;
            $resultado_1 = $conecta->query($sql_1); 

            if($resultado_1 != null)
                foreach($resultado_1 as $linha_1) {
                            // Coletando os dados do Formulario de Cadastro via POST
                    $matriculaTec = $linha_1['matricula'];
                    $registroTec = $linha_1['registro'];
                    $dataAdmissaoTec = $linha_1['dataAdmissao'];
                    $dataRecisaoTec = $linha_1['dataRecisao'];
                    $cargoTec = $linha_1['cargo'];
                    $cpf = $linha_1['cpf'];
                    if($linha_1['statusTecnico']  == '1'){
                        $statusTec = "Ativo"; 
                        $bStatus = "1";
                    }else{
                        $statusTec = "Inativo";
                        $bStatus = "0";
                    }
                         
                }

            $sql_2 = "SELECT * FROM pessoas WHERE cpf = ".$cpf;
            $resultado_2 = $conecta->query($sql_2); 
    
                if($resultado_2 != null)
                    foreach($resultado_2 as $linha_2) {
                                // Coletando os dados do Formulario de Cadastro via POST
                        $nome = $linha_2['nome'];                            
                    }

            $retorno = '';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">
                            <h4 class="w3-text-gray" style="font-weight: bold;">Informações do Técnico</h2>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">
                            <label><b>Nome</b></label>
                            <input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text"
                                placeholder="Nome completo" name="nomeTecExp" value = "'.$nome.'" readonly required>
                        </div>';
            $retorno .='<div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <label><b>Matrícula</b></label>
                            <input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text"
                                placeholder="Registro do conselho de classe" name="matriculaTecExp"  value = "'.$matriculaTec.'" readonly>
                        </div>';
            $retorno .='<div class="w3-half">
                        <label><b>Registro</b></label>
                        <input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text"
                                placeholder="Registro do conselho de classe" name="registroTecExp"  value = "'.$registroTec.'" readonly>
                    </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">
                            <h4 class="w3-text-gray" style="font-weight: bold;">Informações Produto</h2>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half">
                                <label><b>Número do lote</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text"
                                    placeholder="Entre com o número do lote" name="inputLote" value = "'.$numeroLote.'" required>
                            </div>
                            <div class="w3-half">

                            </div>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half">
                                <label><b>Data do experimento</b></label>
                                    <input class="w3-input w3-border  w3-margin-bottom" type="date" placeholder="Data do experimento"
                                        name="dataExperimento" value = "'.$dataExperimento.'"required>
                            </div>
                            <div class="w3-half">
                                <label><b>Data de validade</b></label>
                                    <input class="w3-input w3-border  w3-margin-bottom" type="date" placeholder="validade do experimento"
                                        name="dataValidadeExperimento" value = "'.$dataValidadeExperimento.'" required>
                            </div>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half w3-margin-bottom">
                                <label><b>Peso</b></label>
                                    <input class="w3-input w3-border w3-margin-bottom" type="number" min="0" step="0.01"
                                        placeholder="Peso em quilogramas (Kg)" name="pesoAmostra" value = "'.$peso.'" required>

                            </div>
                            <div class="w3-half">
                                <label><b>Vomule</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="number" min="0" step="0.01"
                                    placeholder="Volume em metros cúbicos (m³)" name="volumeAmostra" value = "'.$volume.'" required>
                            </div>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half w3-margin-bottom">
                                <label><b>PH</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="number"  min="0"  max="10" step="0.1"
                                    placeholder="Valor do PH" name="phAmostra" value = "'.$ph.'"required>

                            </div>
                            <div class="w3-half">
                                <label><b>Temperatura</b></label>
                                    <input class="w3-input w3-border w3-margin-bottom" type="number" step="0.1"
                                        placeholder="Temperatura (°C)" name="temperaturaAmostra" value = "'.$temperatura.'" required>
                            </div>
                        </div>';
            if($salmoura){
                $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                                <div class="w3-half w3-margin-bottom">
                                    <input class="w3-check" name="smAmostra" type="checkbox" checked>
                                    <label><b>Presença de Salmoura</b></label>
                                </div>
                                <div class="w3-half">
                                </div>
                            </div>
                            <br>';
            }else{
                $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                                <div class="w3-half w3-margin-bottom">
                                    <input class="w3-check" name="smAmostra" type="checkbox">
                                    <label><b>Presença de Salmoura</b></label>
                                </div>
                                <div class="w3-half">
                                </div>
                            </div>
                            <br>';

            }

            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half">
                                <label><b>Condição do experimento</b></label>
                                    <select class="w3-select w3-border w3-margin-bottom" name="condicaoExp">
                                        <option value="'.$condicaoExperimento.'" selected>'.$condicaoExperimento.'</option>
                                        <option value="" disabled>Escolha...</option>
                                        <option value="Aprovado">Aprovado</option>
                                        <option value="Reprovado">Reprovado</option>
                                    </select>
                            </div>
                            <div class="w3-half">

                            </div>
                        </div>
                        <br>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">
                            <label><b>Observações</b></label>
                            <textarea class="w3-input w3-border w3-margin-bottom"
                                placeholder="Observações a respeito do experimento" name="obsAmostra" rows="15" style="resize: none"> '.$obsExperimento.'</textarea>
                        </div>
                        <br>';

                echo $retorno;
                
            }
?>











