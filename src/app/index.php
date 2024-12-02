<?php
    use Lib\StateManager;
    use Lib\Request;
    
    $state = new StateManager();
    
    $txtCpf = $state->getState('txtCpf');
    $txtTipo = $state->getState('txtTipo');
    $txtNome = $state->getState('txtNome');
    $txtSenha = $state->getState('txtSenha');
    $txtLogado = $state->getState('txtLogado');
    $errorMessages = $state->getState('errorMessages');

    require_once SRC_PATH.'/../bootstrap.php';

    function fazerlogin($data){
        if(true){

        // inicia uma seção
        session_start();

        // Carrega o arquivo de conexão ao BD
        require_once APP_PATH . '/conexaoBD.php';
        // com o Prisma
        
        // $prisma = Prisma::getInstance();
        //esse código está lá em cima


        // Pegando os valores dos campos CPF e Senha do Formulario via POST
        // $login = $_POST['txtCpf'];
        // $senha_hash =hash('sha256', $_POST['txtSenha']); // Usa a função hash com a Criptografia SHA256

        global $state, $txtCpf, $txtSenha;

        
        try{
            $resultado = $prisma2->pessoas->findUnique([
                'where'=>['cpf'=>$txtCpf]
            ]);
            // $sql = "SELECT * FROM pessoas WHERE cpf =".$login; // SQL para consultar usuario na tabela pessoas com o CPF digitado no formulario
            // $resultado = $conecta->query($sql);
            if($resultado -> rowCount() == 1){
                // foreach($resultado as $linha) {
                    //     if($linha['senha'] == $senha_hash){
                    //         //Cria as variáveis de Seção
                    //         $_SESSION['logado'] = $login;
                    //         $_SESSION['cpf'] = $linha['cpf'];
                    //         $_SESSION['nome'] = $linha['nome'];
                    //         $_SESSION['tipo_usuario'] = $linha['tipo_usuario'];
                    //         //Direciona para a Página Inicial
                    //         Request::redirect('/home');
                    //     }else{
                    //         header ('Location: index.php'); // Caso a senha não corresponda carrega novamente a página de Login
                    // }}
                    // $state->setState('txtCpf', $data->txtCpf);
                    // $state->setState('txtSenha', $data->txtSenha);

                    $state->setState('txtCpf');
                    $state->setState('txtTipo');
                    $state->setState('txtNome');
                    $state->setState('txtSenha');
                    $state->setState('txtLogado');
                            
                    Request::redirect('/home');
                }else{
                    header ('Location: index.php'); // caso não tenha nenhum usuario no banco com o CPF carrega novamente a página de Login
                }
        
            }catch(PDOException $e){
                header ('Location: index.php'); // caso tenha algum erro carrega novamente a página de Login
            }    

        }else{
            header ('Location: index.php'); // Caso a solicitação vinda não senha do botão entrar carrega novamente a página de Login
        }
    }
?>

<div class="w3-container w3-round-xxlarge w3-display-middle w3-card-4 w3-third ">
    <div class="w3-center">
        <br>
        <h2 class="w3-text-teal" style="font-weight: bold;">LABWEB</h2>
    </div>
    <form class="w3-container " onsubmit="fazerlogin" pp-suspense="{'disabled': true}">
        <div class="w3-section">
            <label style="font-weight: bold;">Usuário</label>
            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Digite o cpf (somente números)" name="txtCpf" required>
            <label style="font-weight: bold;">Senha</label>
            <input class="w3-input w3-border" type="password" placeholder="Digite a Senha" name="txtSenha" required>
            <button class="w3-button w3-block w3-teal w3-section w3-padding" type="submit" name="btnEntrar">Entrar</button>
        </div>
    </form>
    <br>
</div>