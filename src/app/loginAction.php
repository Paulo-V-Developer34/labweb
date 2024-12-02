<?php
    
    use Lib\Request;

    if(isset($_POST["btnEntrar"])){

        // inicia uma seção
        session_start();

        // Carrega o arquivo de conexão ao BD
        require_once ('conexaoBD.php');
        // com o Prisma
        
        // $prisma = Prisma::getInstance();
        //esse código está lá em cima


        // Pegando os valores dos campos CPF e Senha do Formulario via POST
        $login = $_POST['txtCpf'];
        $senha_hash =hash('sha256', $_POST['txtSenha']); // Usa a função hash com a Criptografia SHA256

        try{
            $resultado = $prisma2->pessoas->findUnique([
                'where'=>['cpf'=>$login]
            ]);
            // $sql = "SELECT * FROM pessoas WHERE cpf =".$login; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            // $resultado = $conecta->query($sql);
            if($resultado -> rowCount() == 1){
                foreach($resultado as $linha) {
                    if($linha['senha'] == $senha_hash){
                        //Cria as variáveis de Seção
                        $_SESSION['logado'] = $login;
                        $_SESSION['cpf'] = $linha['cpf'];
                        $_SESSION['nome'] = $linha['nome'];
                        $_SESSION['tipo_usuario'] = $linha['tipo_usuario'];
                        //Direciona para a Página Inicial
                        Request::redirect('/home');
                    }else{
                        header ('Location: index.php'); // Caso a senha não corresponda carrega novamente a página de Login
                    }}
            }else{
                header ('Location: index.php'); // caso não tenha nenhum usuario no banco com o CPF carrega novamente a página de Login
            }
    
        }catch(PDOException $e){
            header ('Location: index.php'); // caso tenha algum erro carrega novamente a página de Login
        }    

    }else{
        header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
    }

?>