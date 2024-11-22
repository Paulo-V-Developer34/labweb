<nav class="w3-sidebar w3-bar-block w3-center">
        <div class="w3-container w3-border-top w3-padding-large w3-white">
            <h4 class="w3-text-teal" style="font-weight: bold;">LABWEB</h2>
        </div>
        <!-- HOME -->
        <a href="paginaInicial.php"
            class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-hover-text-teal w3-text-white">
            <i class="fa fa-home w3-xxlarge"></i>
            <p>HOME</p>
        </a>

        <?php
            if($_SESSION["tipo_usuario"] == "1"){
                echo '<!-- Clientes -->
                        <a href="paginaClientes.php"
                            class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-hover-text-teal w3-text-white">
                            <i class="fa fa-user w3-xxlarge"></i>
                            <p>CLIENTES</p>
                        </a>
                        <!-- Técnicos -->
                        <a href="paginaTecnicos.php"
                            class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-hover-text-teal w3-text-white">
                            <i class="fa fa-flask w3-xxlarge"></i>
                            <p>TÉCNICOS</p>
                        </a>
                        <!-- Administradores -->
                        <a href="paginaAdministradores.php"
                            class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-hover-text-teal w3-text-white">
                            <i class="fa fa-user w3-xxlarge"></i>
                            <p>ADM</p>
                        </a>';
            }
        ?>

        <!-- Fazer Logout -->
        <a href="logoutAction.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-hover-text-teal w3-text-white">
            <p>SAIR</p>
        </a>
</nav>