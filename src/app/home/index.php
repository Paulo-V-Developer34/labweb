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

        #main {
            margin-left: 150px;
        }

        /*colocar o mesmo valor da largura da sidebar*/
    </style>
</head>

<body>
    <?php
        // Inclui o arquivo que verifica o acesso do usuario
        require_once ('../verificarAcesso.php'); 
        // Carrega a barra de navegação na página
        require_once ('../barraNav.php');
    ?>
 
    <!-- Div que irá conter o conteúdo principal da página-->
    <div class="w3-padding-large" id="main">
        <h2 class="w3-text-black w3-center" style="font-weight: bold;">Experimentos Cadastrados</h2>

        <?php
            use Lib\StateManager;
            $state = new StateManager();

            if($state->getState('txtTipo') == "2"){
                echo '<a href="#" class="w3-button w3-padding w3-text-teal w3-cell w3-left">
                        <button class="w3-button w3-round cadastrarNovoBtnExp" style="font-weight: bold;"><i class="fa fa-plus "></i> Novo</button>
                    </a>';
            }
        ?>

        <?php

            // Carrega o arquivo de conexão ao BD
            require_once ('../conexaoBD.php');

                // Monta tabela de apresentaçao dos Experimentos Cadastrados
                echo '
                    <table class="w3-table-all w3-centered w3-text-black" id="experimentosTabela">
                    <thead>
                        <tr class="w3-center w3-teal">
                            <th>Lote</th>
                            <th>Data</th>
                            <th>Validade</th>
                            <th>Técnico</th>
                            <th>Registro</th>
                            <th>Condição</th>
                            <th>Ações</th>
                        </tr>
                    <thead>
                    <tbody>
                ';
                // $sql = "SELECT * FROM experimentos" ;
                // $resultado = $conecta->query($sql);
                // $resultado = $prisma->experimentos->findMany([])
                $resultado = $prisma2->experimentos->findMany();

                if($resultado != null) {
                    foreach($resultado as $linha) {
                        echo '<tr>';
                        echo '<td>'.$linha["numeroLote"].'</td>';
                        echo '<td>'.date("d/m/Y",strtotime($linha['dataExperimento'])).'</td>';
                        echo '<td>'.date("d/m/Y",strtotime($linha['dataValidadeExperimento'])).'</td>';

                        // $sql_2 = "SELECT * FROM pessoas WHERE cpf = (SELECT cpf FROM tecnicos WHERE matricula =".$linha['matriculaTecnico'].")" ;
                        // $resultado_2 = $conecta->query($sql_2);

                        $resultado_2 = $prisma2->tecnicos->findUnique([
                            'where'=>['matricula'=>$linha['matriculaTecnico']],
                            'select'=>['cpf'=>['select'=>['nome'=>true]]]
                        ]);


                        
                        foreach($resultado_2 as $linha_2) {
                            echo '<td>'.$linha_2['nome'].'</td>';
                        }

                        // $sql_3 = "SELECT * FROM tecnicos WHERE matricula =".$linha['matriculaTecnico'];
                        // $resultado_3 = $conecta->query($sql_3);
                        $resultado_3 = $prisma2->tecnicos->findUnique([
                            'where'=>['matricula'=>$linha['matriculaTecnico']]
                        ]);

                        
                        foreach($resultado_3 as $linha_3) {
                           echo '<td>'.$linha_3['registro'].'</td>';
                        }  
                        echo '<td>'.$linha['condicaoExperimento'].'</td>';
                        echo '<td>';
                        if($state->getState('txtTipo'); == "2"){
                            echo '<button type = "button" class="w3-button w3-white w3-border w3-border-default w3-tiny w3-round editarBtnExp" id="'.$linha['numeroLote'].'"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                        }
                        if($state->getState('txtTipo'); == "2" or $state->getState('txtTipo'); == "1"){
                            echo '<button type = "button" class="w3-button w3-white w3-border w3-border-default w3-tiny w3-round excluirBtnExp" id="'.$linha['numeroLote'].'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
                        }
                                
                        echo '<button type = "button" class="w3-button w3-white w3-border w3-border-default w3-tiny w3-round visualizarBtnExp" id="'.$linha['numeroLote'].'"><i class="fa fa-eye" aria-hidden="true"></i></button>
                              <a type = "button" class="w3-button w3-white w3-border w3-border-default w3-tiny w3-round" href = "gerarPDF.php?numeroLote='.$linha['numeroLote'].'"><i class="fa fa-print" aria-hidden="true"></i></a>
                            </td>';
                    }
                }
                echo '      </tbody> 
                        </table>' ;

        ?>
    </div>

    <!-- Modal para cadastro de novos experimentos-->
    <div id="modalNovoExperimento" class="w3-modal">
        <div class="w3-modal-content w3-modal-content-scrollable w3-card-4 w3-animate-zoom" style="max-width:600px">

            <div class="w3-center"><br>
                <span onclick="document.getElementById('modalNovoExperimento').style.display='none'"
                    class="w3-button w3-xlarge w3-hover-red w3-display-topright" class="close">&times;</span>
                <h2 class="w3-text-teal" style="font-weight: bold;">Novo Experimento</h2>
            </div>

            <form class="w3-container" action="cadastrarExperimento.php" method="post">
                <div class="w3-section">
                    <div class="w3-row-padding" style="margin:0 -8px;">
                        <h4 class="w3-text-gray" style="font-weight: bold;">Informações do Técnico</h2>
                    </div>

                    <?php

                        // Carrega o arquivo de conexão ao BD
                        require_once ('conexaoBD.php');

                        
                            // $sql = "SELECT nome FROM pessoas WHERE cpf = ".$_SESSION['cpf'];
                            // $resultado = $conecta->query($sql);

                            $resultado = $prisma2->pessoas->findUnique([
                                'where'=>['cpf'=>$_SESSION['cpf']],
                                'select'=>['nome'=>true]
                            ]);

                            if($resultado != null)
                                foreach($resultado as $linha) {
                                    echo '<div class="w3-row-padding" style="margin:0 -8px;">
                                            <label><b>Nome</b></label>
                                            <input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text"
                                                placeholder="Nome completo" name="nomeTecExp" value = "'.$linha['nome'].'" readonly>
                                            </div>';
                                }
                            

                            // $sql_2 = "SELECT * FROM tecnicos WHERE cpf = ".$_SESSION['cpf'];
                            // $resultado_2 = $conecta->query($sql_2);
                            $resultado_2 = $prisma2->tecnicos->findUnique([
                                'where'=>['cpf'=>$_SESSION['cpf']],
                                'select'=>['matricula'=>true,'registro'=>true]
                            ]);
                                    
                            foreach($resultado_2 as $linha_2) {
                                echo '<div class="w3-row-padding" style="margin:0 -16px;">
                                <div class="w3-half">
                                    <label><b>Matrícula</b></label>
                                    <input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text"
                                        placeholder="Registro do conselho de classe" name="matriculaTecExp"  value = "'.$linha_2['matricula'].'" readonly>
                                </div>';

                                echo '<div class="w3-half">
                                        <label><b>Registro</b></label>
                                        <input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text"
                                            placeholder="Registro do conselho de classe" name="registroTecExp"  value = "'.$linha_2['registro'].'" readonly>
                                    </div>';
                            }


                            echo '</div>';


                    ?>

                    <div class="w3-row-padding" style="margin:0 -8px;">
                        <h4 class="w3-text-gray" style="font-weight: bold;">Informações Produto</h2>
                    </div>
                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <label><b>Número do lote</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text"
                                placeholder="Entre com o número do lote" name="inputLote" required>
                        </div>
                        <div class="w3-half">

                        </div>
                    </div>
                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <label><b>Data do experimento</b></label>
                                <input class="w3-input w3-border  w3-margin-bottom" type="date" placeholder="Data do experimento"
                                    name="dataExperimento" required>
                        </div>
                        <div class="w3-half">
                            <label><b>Data de validade</b></label>
                                <input class="w3-input w3-border  w3-margin-bottom" type="date" placeholder="validade do experimento"
                                    name="dataValidadeExperimento" required>
                        </div>
                    </div>
                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half w3-margin-bottom">
                            <label><b>Peso</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="number" min='0' step="0.01"
                                    placeholder="Peso em quilogramas (Kg)" name="pesoAmostra" required>

                        </div>
                        <div class="w3-half">
                            <label><b>Vomule</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="number" min='0' step="0.01"
                                placeholder="Volume em metros cúbicos (m³)" name="volumeAmostra" required>
                        </div>
                    </div>

                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half w3-margin-bottom">
                            <label><b>PH</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="number"  min='0'  max='10' step="0.1"
                                placeholder="Valor do PH" name="phAmostra" required>

                        </div>
                        <div class="w3-half">
                            <label><b>Temperatura</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="number" step="0.1"
                                    placeholder="Temperatura (K)" name="temperaturaAmostra" required>
                        </div>
                    </div>

                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half w3-margin-bottom">
                            <input class="w3-check" name="smAmostra" type="checkbox" value = "1">
                            <label><b>Presença de Salmoura</b></label>
                        </div>
                        <div class="w3-half">
                        </div>
                    </div>
                    <br>
                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <label><b>Condição do experimento</b></label>
                                <select class="w3-select w3-border w3-margin-bottom" name="condicaoExp" required>
                                    <option value="" disabled selected>Escolha...</option>
                                    <option value="Aprovado">Aprovado</option>
                                    <option value="Reprovado">Reprovado</option>
                                </select>
                        </div>
                        <div class="w3-half">

                        </div>
                    </div>
                    <br>

                    <div class="w3-row-padding" style="margin:0 -8px;">
                        <label><b>Observações</b></label>
                        <textarea class="w3-input w3-border w3-margin-bottom"
                            placeholder="Observações a respeito do experimento" name="obsAmostra" rows="15" style="resize: none" required></textarea>
                    </div>

                    <br>

                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <button onclick="document.getElementById('modalNovoExperimento').style.display='none'" class="w3-button w3-block w3-gray w3-section w3-padding w3-text-white"><b>Cancelar</b></button>
                        </div>
                        <div class="w3-half w3-margin-bottom">
                            <button class="w3-button w3-block w3-teal w3-section w3-padding" type="submit" name = "btnCadastrarExperimento"><b>Cadastrar</b></button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar um experimento -->
    <div id="modalEditarExp" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

            <div class="w3-center"><br>
                <span onclick="document.getElementById('modalEditarExp').style.display='none'"
                    class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <h2 class="w3-text-teal" style="font-weight: bold;">Editar Experimento</h2>
            </div>

            <form class="w3-container" action="editarExp.php" method="post">
                <div class="w3-section">
                    <span id = "infoEditarExp"></span>
                    <br>
                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <button type = "button" onclick="document.getElementById('modalEditarExp').style.display='none'" class="w3-button w3-block w3-gray w3-section w3-padding w3-text-white"><b>Cancelar</b></button>
                        </div>
                        <div class="w3-half w3-margin-bottom">
                            <button class="w3-button w3-block w3-teal w3-section w3-padding" type="submit" name = "btnEditarExpModal"><b>Salvar</b></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para excluir um experimento -->
    <div id="modalExcluirExp" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:400px">

            <div class="w3-center"><br>
                <span onclick="document.getElementById('modalExcluirExp').style.display='none'"
                    class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <h2 class="w3-text-teal" style="font-weight: bold;">Excluir Experimento</h2>
            </div>

            <form class="w3-container" action="excluirExperimento.php" method="post">
                <div class="w3-section">
                    <p>Confirme os dados do experimento e clique em <strong>Excluir</strong> se realmente desejar excluir o experimento da base de dados.</p>
                    <br>
                    <span id = "infoExcluirExp"></span>
                    <br>
                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <div class="w3-half">
                            <button type = "button" onclick="document.getElementById('modalExcluirExp').style.display='none'" class="w3-button w3-block w3-gray w3-section w3-padding w3-text-white"><b>Cancelar</b></button>
                        </div>
                        <div class="w3-half w3-margin-bottom">
                            <button class="w3-button w3-block w3-teal w3-section w3-padding" type="submit" name = "btnExcluirExpModal"><b>Excluir</b></button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal para visualizar um relatório de um experimento -->
    <div id="modalVisualizarExp" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

            <div class="w3-center"><br>
                <span onclick="document.getElementById('modalVisualizarExp').style.display='none'"
                    class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <h2 class="w3-text-teal" style="font-weight: bold;">Visualiza Experimento</h2>
            </div>

            <div class="w3-container">
                    <span id = "infoVisualizaExp"></span>
            </div>
        </div>
    </div>

    <!-- Scrip em Js -->
    <script type="text/javascript">

        $(document).on('click','.cadastrarNovoBtnExp', function(){
            var modalExcluir = document.getElementById('modalNovoExperimento');
                    modalExcluir.style.display = "block";
        });

        $(document).on('click','.editarBtnExp', function(){
            var numeroLote = $(this).attr("id");
            
            //verifica se há valor na variável "numeroLote"
            if(numeroLote !== ''){
                var dados = {
                    numeroLote: numeroLote
                };

                $.post('visualizaEditarExp.php', dados, function(retorna){

                    $("#infoEditarExp").html(retorna);
                    //Abre o conteúdo do Modal para o usuário
                    var modalEditar = document.getElementById('modalEditarExp');
                    modalEditar.style.display = "block";
                });                
            }
        });

        $(document).on('click','.excluirBtnExp', function(){
            var numeroLote = $(this).attr("id");
            
            //verifica se há valor na variável "numeroLote"
            if(numeroLote !== ''){
                var dados = {
                    numeroLote: numeroLote
                };

                $.post('visualizaExcluirExp.php', dados, function(retorna){

                    $("#infoExcluirExp").html(retorna);
                    //Abre o conteúdo do Modal para o usuário
                    var modalExcluir = document.getElementById('modalExcluirExp');
                    modalExcluir.style.display = "block";
                });                
            }
        });

        $(document).on('click','.visualizarBtnExp', function(){
            var numeroLote = $(this).attr("id");
            
            //verifica se há valor na variável "numeroLote"
            if(numeroLote !== ''){
                var dados = {
                    numeroLote: numeroLote
                };

                $.post('visualizaRelatorioExp.php', dados, function(retorna){

                    $("#infoVisualizaExp").html(retorna);
                    //Abre o conteúdo do Modal para o usuário
                    var modalEditar = document.getElementById('modalVisualizarExp');
                    modalEditar.style.display = "block";
                });                
            }
        });

        // Inicializando o DataTables para a Tabela
        $(document).ready(function() {
            $('#experimentosTabela').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
                },
                paging: true
            });
        });

        $(document).on('click','.gerarPDF', function(){
            var numeroLote = $(this).attr("id");
            
            //verifica se há valor na variável "numeroLote"
            if(numeroLote !== ''){
                var dados = {
                    numeroLote: numeroLote
                };

                $.post('gerarPDF.php', dados, function(){
                });                
            }
        })
    </script>

    <!-- Incluir arquivo JS do DataTables -->
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>

</body>

</html>