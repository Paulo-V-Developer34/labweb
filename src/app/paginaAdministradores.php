<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
    <link rel="icon" href="img/logo_labweb.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>LabWeb - Controle de Qualidade</title>
    <style>
        /* Definimos que a sidebar terá uma largura de 120px e cor a cord de fundo #222
        */
        .w3-sidebar {
            width: 150px;
            background: #222;
        }

        /*Define Fonte para todas as tags listadas abaixo*/
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Montserrat", sans-serif;
        }

        #mainADM {
            margin-left: 150px;
        }

        /*colocar o mesmo valor da largura da sidebar*/
    </style>
</head>

<body>
    
    <?php
        // Inclui o arquivo que verifica o acesso do usuario
        require_once ('verificarAcesso.php');  
        // Carrega a barra de navegação na página
        require_once ('barraNav.php');

        // Segurança para quem não é usuario Adiministrador acessar a página
        if(($_SESSION['tipo_usuario'] != '1')){
            unset( $_SESSION['logado'] );
            unset( $_SESSION['cpf'] );
            unset( $_SESSION['nome'] );
            unset( $_SESSION['tipo_usuario'] );  
        
            session_destroy();
            header('location:index.php'); 
            die();
        }
    ?>

    <!-- Div que irá conter o conteúdo principal da página-->
    <div class="w3-padding-large" id="mainADM">
        <h2 class="w3-text-black w3-center" style="font-weight: bold;">Administradores Cadastrados</h2>
        
        <?php  
            if($_SESSION['tipo_usuario'] == 'root'){
                echo ' <a href="#" class="w3-button w3-padding w3-text-teal w3-cell w3-left">
                                <button onclick="document.getElementById("modalNovoADM").style.display="block""
                                class="w3-button w3-round" style="font-weight: bold;"><i class="fa fa-plus "></i> Novo</button>
                        </a>';
            }
        ?>

        <!-- Código em PHP para consultar o banco de dados e verificar -->
        <?php

            // Carrega o arquivo de conexão ao BD
            require_once ('conexaoBD.php');

            try{
                //Monta a tabela de apresentação dos Administradores Cadastrados
                echo '
                    <table class="w3-table-all w3-centered w3-text-black" id = "administradoresTabela">
                    <thead>
                        <tr class="w3-center w3-teal">
                            <th>Matrícula</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Cargo</th>
                            <th>Status</th>';
                        if($_SESSION['tipo_usuario'] == 'root'){
                            echo ' <th>Ações</th>';
                        }
                            
                echo '  </tr>
                    </thead>
                    <tbody>
                ';
                $sql = "SELECT * FROM administradores" ;
                $resultado = $conecta->query($sql);
                if($resultado != null)
                    foreach($resultado as $linha) {
                        echo '<tr>';
                        echo '<td>'.$linha['matricula'].'</td>';

                        $sql_2 = "SELECT nome FROM pessoas WHERE cpf = (SELECT cpf FROM administradores WHERE matricula =".$linha['matricula'].")" ;
                        $resultado_2 = $conecta->query($sql_2);
                        
                        foreach($resultado_2 as $linha_2) {
                            echo '<td>'.$linha_2['nome'].'</td>';
                            echo '<td>'.$linha['cpf'].'</td>';
                        }

                        echo '<td>'.$linha['cargo'].'</td>';

                        //Verifica se o técnico esta ativo ou inativo, se o statusTecnico for 1 ele esta ativo, caso contrário está inativo
                        if($linha['statusAdministrador'] == 1){
                            $statusADM = "Ativo";
                        }else{
                            $statusADM = "Inativotivo";
                        }
                        
                        echo '<td>'.$statusADM.'</td>';
                        if($_SESSION['tipo_usuario'] == 'root'){
                                echo '<td>
                                        <button type = "button" class="w3-button w3-white w3-border w3-border-default w3-tiny w3-round editarBtnADM" id="'.$linha['matricula'].'"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <button type = "button" class="w3-button w3-white w3-border w3-border-default w3-tiny w3-round excluirBtnADM" id="'.$linha['matricula'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>';
                        }

                    }
                echo '</tbody>
                    </table>' ;
            }catch(PDOException $e){
                echo "falha ao conectar: ". $e->getMessage();
            }
        ?>
    </div>

   <!-- Modal para cadastro de novos administradores-->
   <div id="modalNovoADM" class="w3-modal">
        <div class="w3-modal-content w3-modal-content-scrollable w3-card-4 w3-animate-zoom" style="max-width:600px">

            <div class="w3-center"><br>
                <span onclick="document.getElementById('modalNovoADM').style.display='none'"
                    class="w3-button w3-xlarge w3-hover-red w3-display-topright" class="close">&times;</span>
                <h2 class="w3-text-teal" style="font-weight: bold;">Novo Administrador</h2>
            </div>

            <form class="w3-container" action="cadastrarADM.php" method="post">
                <div class="w3-section">
                    <div class="w3-row-padding" style="margin:0 -8px;">
                        <h4 class="w3-text-gray" style="font-weight: bold;">Dados Pessoais</h2>
                    </div>
                    <div class="w3-row-padding" style="margin:0 -8px;">
                        <label><b>Nome</b></label>
                        <input class="w3-input w3-border w3-margin-bottom" type="text"
                                placeholder="Nome completo" name="nomeADM" required>
                    </div>
                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <label><b>CPF</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text"
                                placeholder="Número CPF (Somento números)" name="cpfADM" required>
                        </div>
                        <div class="w3-half">
                            <label><b>Email</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="email"
                                    placeholder="Email" name="emailADM" required>
                        </div>
                    </div>
                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half w3-margin-bottom">
                            <label><b>Telefone Celular</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text"
                                placeholder="Telefone Celular (Whatsapp)" name="celularADM" required>
                        </div>
                        <div class="w3-half">
                            <label><b>Telefone Fixo</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="text"
                                    placeholder="Telefone Fixo" name="telefoneFixoADM">
                        </div>
                    </div>

                    <div class="w3-row-padding" style="margin:0 -8px;">
                        <h4 class="w3-text-gray" style="font-weight: bold;">Endereço</h4>
                    </div>

                    <div class="w3-row-padding" style="margin:0 -8px;">
                        <label><b>Logradouro</b></label>
                        <input class="w3-input w3-border w3-margin-bottom" type="text"
                                placeholder="Rua/Avenida e número" name="ruaADM" required>
                    </div>

                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-third w3-margin-bottom">
                            <label><b>Cidade</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text"
                                    placeholder="Cidade" name="cidadeADM" required>
                        </div>
                        <div class="w3-third w3-margin-bottom">
                            <label><b>Bairro</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text"
                                    placeholder="Bairro" name="bairroADM" required>
                        </div>
                        <div class="w3-third">
                            <label><b>Estado</b></label>
                            <select class="w3-select w3-border w3-margin-bottom" name="estadoADM" required>
                                <option value="" disabled selected>Escolha...</option>
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
                    </div>

                    <div class="w3-row-padding" style="margin:0 -8px;">
                        <h4 class="w3-text-gray" style="font-weight: bold;">Dados Profissionais</h2>
                    </div>

                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <label><b>Cargo</b></label>
                            <select class="w3-select w3-border w3-margin-bottom" name="cargoADM">
                                <option value="" disabled selected>Escolha...</option>
                                <option value="Engenheiro">Engenheiro</option>
                                <option value="Técnico">Técnico</option>
                                <option value="Supervisor">Supervisor</option>
                            </select>
                        </div>
                    </div>

                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half w3-margin-bottom">
                            <label><b>Data de Admissão</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="date"
                                placeholder="Data de Admissão" name="dataAdmissaoADM" required>
                        </div>
                    </div>

                    <div class="w3-row-padding" style="margin:0 -8px;">
                        <h4 class="w3-text-gray" style="font-weight: bold;">Senha</h2>
                    </div>

                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <label><b>Senha</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="password"
                                placeholder="Digite a senha" name="senhaADM" required>
                        </div>
                        <div class="w3-half">
                            <label><b>Confirmação da Senha</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="password"
                                placeholder="Repita a senha para confirmação" name="confirmaSenhaADM" required>
                        </div>
                    </div>

                    <br>

                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <button onclick="document.getElementById('modalNovoADM').style.display='none'" class="w3-button w3-block w3-gray w3-section w3-padding w3-text-white"><b>Cancelar</b></button>
                        </div>
                        <div class="w3-half w3-margin-bottom">
                            <button class="w3-button w3-block w3-teal w3-section w3-padding" type="submit" name = "btnCadastrarADM"><b>Cadastrar</b></button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- Modal para excluir um técnico -->
    <div id="modalExcluirADM" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">

            <div class="w3-center"><br>
                <span onclick="document.getElementById('modalExcluirADM').style.display='none'"
                    class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <h2 class="w3-text-teal" style="font-weight: bold;">Excluir Administrador</h2>
            </div>

            <form class="w3-container" action="excluirADM.php" method="post">
                <div class="w3-section">
                    <p>Confirme os dados do administrador e clique em <strong>Excluir</strong> se realmente desejar excluir o administrador da base de dados.</p>
                    <br>
                    <span id = "infoExcluirADM"></span>
                    <br>
                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <button type = "button" onclick="document.getElementById('modalExcluirADM').style.display='none'" class="w3-button w3-block w3-gray w3-section w3-padding w3-text-white"><b>Cancelar</b></button>
                        </div>
                        <div class="w3-half w3-margin-bottom">
                            <button class="w3-button w3-block w3-teal w3-section w3-padding" type="submit" name = "btnExcluirADMModal"><b>Excluir</b></button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Scrip em Js para pegar a matricula do técnico quando clicar no botão excluir e enviar os dados para o Modal -->
    <script type="text/javascript">

        $(document).on('click','.excluirBtnADM', function(){
            var adm_matricula = $(this).attr("id");
            
            //verifica se há valor na variável "tecnico_matricula"
            if(adm_matricula !== ''){
                var dados = {
                    adm_matricula: adm_matricula
                };

                $.post('visualizaExcluirADM.php', dados, function(retorna){

                    $("#infoExcluirADM").html(retorna);
                    //Abre o conteúdo do Modal para o usuário
                    var modalExcluir = document.getElementById('modalExcluirADM');
                    modalExcluir.style.display = "block";
                });                
            }
        })
        // Inicializando o DataTables para a Tabela
        $(document).ready(function() {
            $('#administradoresTabela').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
                },
                paging: true
            });
        });
    </script>

    <!-- Incluir arquivo JS do DataTables -->
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>

</body>

</html>