<?php
        // Inclui o arquivo que verifica o acesso do usuario
        require_once ('verificarAcesso.php');
        
        if(isset($_POST["tecnico_matricula"])){

            // Carrega o arquivo de conexão ao BD
            require_once ('conexaoBD.php');

            $sql = "SELECT * FROM pessoas WHERE cpf = (SELECT cpf FROM tecnicos WHERE matricula = ".$_POST["tecnico_matricula"].")";
            $resultado = $conecta->query($sql); 

            $retorno = '';
            if($resultado != null)
                foreach($resultado as $linha) {
                            // Coletando os dados do Formulario de Cadastro via POST
                    $nome = $linha['nome'];
                    $cpf = $linha['cpf'];
                    $email = $linha['email'];
                    $celularTec = $linha['telefoneCelular'];
                    $telefoneFixoTec = $linha['telefoneFixo'];
                    $ruaTec = $linha['rua'];
                    $bairroTec = $linha['bairro'];
                    $cidadeTec = $linha['cidade'];
                    $estadoTec = $linha['estado'];       
                }

            
            $sql_1 = "SELECT * FROM tecnicos WHERE matricula = ".$_POST["tecnico_matricula"];
            $resultado_1 = $conecta->query($sql_1); 

            if($resultado_1 != null)
                foreach($resultado_1 as $linha_1) {
                            // Coletando os dados do Formulario de Cadastro via POST
                    $matriculaTec = $linha_1['matricula'];
                    $registroTec = $linha_1['registro'];
                    $dataAdmissaoTec = $linha_1['dataAdmissao'];
                    $dataRecisaoTec = $linha_1['dataRecisao'];
                    $cargoTec = $linha_1['cargo'];
                    if($linha_1['statusTecnico']  == '1'){
                        $statusTec = "Ativo"; 
                        $bStatus = "1";
                    }else{
                        $statusTec = "Inativo";
                        $bStatus = "0";
                    }
                         
                }

            $retorno = '';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half">
                                <label><b>Matricula</b></label>
                                <input class="w3-input w3-border w3-margin-botto w3-light-grey" type="text"
                                    placeholder="Empresa do cliente" name="matriculaTec" value ="'.$_POST['tecnico_matricula'].'" readonly required>
                            </div>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;"><h4 class="w3-text-gray" style="font-weight: bold;">Dados Pessoais</h2></div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;"><label><b>Nome</b></label><input class="w3-input w3-border w3-margin-bottom" type="text"placeholder="Nome completo" name="nomeTec" value = "'.$nome.'" required></div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half">
                                <label><b>CPF</b></label>
                                <input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text"
                                    placeholder="Número CPF (Somento números)" name="cpfTec" value = "'.$cpf.'" readonly required>
                            </div>
                            <div class="w3-half">
                                <label><b>Email</b></label>
                                    <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Email" name="emailTec" value = "'.$email.'" required>
                            </div>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half w3-margin-bottom">
                                <label><b>Telefone Celular</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text"
                                    placeholder="Telefone Celular (Whatsapp)" name="celularTec" value = "'.$celularTec.'" required>
                            </div>
                            <div class="w3-half">
                                <label><b>Telefone Fixo</b></label>
                                    <input class="w3-input w3-border w3-margin-bottom" type="text"
                                        placeholder="Telefone Fixo" name="telefoneFixoTec" value = "'.$telefoneFixoTec.'">
                            </div>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">
                            <h4 class="w3-text-gray" style="font-weight: bold;">Endereço</h4>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">
                            <label><b>Logradouro</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text"
                                    placeholder="Rua/Avenida e número" name="ruaTec" value = "'.$ruaTec.'" required>
                        </div>';

            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-third w3-margin-bottom">
                                <label><b>Cidade</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text"
                                        placeholder="Cidade" name="cidadeTec" value = "'.$cidadeTec.'" required>
                            </div>
                            <div class="w3-third w3-margin-bottom">
                                <label><b>Bairro</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text"
                                        placeholder="Bairro" name="bairroTec" value = "'.$bairroTec.'" required>
                            </div>
                            <div class="w3-third">
                                <label><b>Estado</b></label>
                                <select class="w3-select w3-border w3-margin-bottom" name="estadoTec" required>
                                    <option value='.$estadoTec.' selected>'.$estadoTec.'</option>
                                    <option value="">Escolha...</option>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AP">AP</option>
                                    <option value="AM">AM</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                    <option value="MG">MG</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PR">PR</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RS">RS</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="SC">SC</option>
                                    <option value="SP">SP</option>
                                    <option value="SE">SE</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>
                        </div>';

            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">
                            <h4 class="w3-text-gray" style="font-weight: bold;">Outros</h2>
                        </div>';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half">
                                <label><b>Registro</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text"
                                    placeholder="Empresa do cliente" name="registroTec" value ="'.$registroTec.'" required>
                            </div>
                            <div class="w3-half">
                                <label><b>Cargo</b></label>
                                <select class="w3-select w3-border w3-margin-bottom" name="cargoTec">
                                    <option value="'.$cargoTec.'" selected>'.$cargoTec.'</option>
                                    <option value="">Escolha...</option>
                                    <option value="Engenheiro">Engenheiro</option>
                                    <option value="Técnico">Técnico</option>
                                    <option value="Supervisor">Supervisor</option>
                                </select>
                            </div>
                        </div>'; 
            $retorno .= '<div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half w3-margin-bottom">
                            <label><b>Data de Admissão</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="date"
                                placeholder="Data de Admissão" name="dataAdmissaoTec"  value ="'.$dataAdmissaoTec.'" required>
                        </div>
                    </div>';

            $retorno .= '<div class="w3-half">
                            <label><b>Status</b></label>
                            <select class="w3-select w3-border w3-margin-bottom" name="statusTec" required>
                                <option value="'.$bStatus.'" selected>'.$statusTec.'</option>
                                <option value="">Escolha...</option>
                                <option value= 1>Ativo</option>
                                <option value= 0>Inativo</option>
                            </select>
                        </div>';

            $retorno .= '<br>';

                echo $retorno;
                
            }
?>