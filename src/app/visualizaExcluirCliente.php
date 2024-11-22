<?php
        // Inclui o arquivo que verifica o acesso do usuario
        require_once ('verificarAcesso.php');
        
        if(isset($_POST["numero_cliente"])){

            // Carrega o arquivo de conexão ao BD
            require_once ('conexaoBD.php');

            $sql = "SELECT * FROM clientes WHERE numero = ".$_POST["numero_cliente"];
            $resultado = $conecta->query($sql); 

            $retorno = '';
            if($resultado != null)
            foreach($resultado as $linha) {

                // Monta tabela de apresentaçao dos Técnicos Cadastrados
                /*$retorno .= '<table class="w3-table-all w3-centered w3-text-black">';
                $retorno .= '<thead> <tr class="w3-center w3-gray w3-text-white"> <th>Matrícula</th> <th>Nome</th> <th>CPF</th> </tr> <thead>';
                $retorno .= '<tr>';
                $retorno .= '<td name = "matriculaTecExcluir">'.$linha['matricula'].'</td>';*/

                $sql_2 = "SELECT nome FROM pessoas WHERE cpf = (SELECT cpf FROM clientes WHERE numero =".$linha['numero'].")" ;
                $resultado_2 = $conecta->query($sql_2);
                
                /*foreach($resultado_2 as $linha_2) {
                    $retorno .= '<td name = "nomeTecExcluir">'.$linha_2['nome'].'</td>';
                }

                $retorno .= '<td name = "cpfTecExcluir">'.$linha['cpf'].'</td>';
                $retorno .= '</tr>';*/
                
                foreach($resultado_2 as $linha_2) {
                    $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">';
                    $retorno .= '<label><b>Nome</b></label>';
                    $retorno .= '<input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text" name = "nomeClienteExcluir" readonly value = '.$linha_2['nome'].'>';
                    $retorno .= '</div>';
                }

                $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">';
                $retorno .= '<label><b>CPF</b></label>';
                $retorno .= '<input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text" name = "cpfClienteExcluir" readonly value = '.$linha['cpf'].'>';
                $retorno .= '</div>';

                $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">';
                $retorno .= '<label><b>Matrícula</b></label>';
                $retorno .= '<input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text" name = "numeroClienteExcluir" readonly value = '.$linha['numero'].'>';
                $retorno .= '</div>';

                echo $retorno;
                
            }

        }
?>