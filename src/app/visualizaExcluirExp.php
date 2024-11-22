<?php
        // Inclui o arquivo que verifica o acesso do usuario
        require_once ('verificarAcesso.php');
        
        if(isset($_POST["numeroLote"])){

            $retorno = '';
            $retorno .= '<div class="w3-row-padding" style="margin:0 -8px;">';
            $retorno .= '<label><b>Número do Lote</b></label>';
            $retorno .= '<input class="w3-input w3-border w3-margin-bottom w3-light-grey" type="text" name = "numeroLote" readonly value = '.$_POST["numeroLote"].'>';
            $retorno .= '</div>';

            echo $retorno;
                
        }
?>