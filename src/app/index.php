<?php 
    use Lib\Request;
    use Lib\Prisma\Classes\Prisma;

    // $prisma = Prisma::getInstance();

    require_once __DIR__.'/../../bootstrap.php'
?>

<div class="w3-container w3-round-xxlarge w3-display-middle w3-card-4 w3-third ">
    <div class="w3-center">
        <br>
        <h2 class="w3-text-teal" style="font-weight: bold;">LABWEB</h2>
    </div>
    <form class="w3-container " action="loginAction.php" method="post">
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