<?php
    // Inclui o arquivo que verifica o acesso do usuario
    require_once ('verificarAcesso.php');
     
    unset( $_SESSION['logado'] );
    unset( $_SESSION['cpf'] );
    unset( $_SESSION['nome'] );
    unset( $_SESSION['tipo_usuario'] );  

    session_destroy();

    header("location:index.php");
    die();
?>