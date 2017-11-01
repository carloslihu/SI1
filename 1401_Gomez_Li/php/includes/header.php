<div class="pageTop">
    <div class="header">
        <p class="header_text"><a href="index.php">Tienda de DvDs</a></p>
    </div>
    <div class="topnav">
        <?php
        if (isset($_SESSION["username"])) {
            echo '
    
    <a href="cesta.php">Cesta</a>
    <a href="history.php">' . $_SESSION['username'] . '</a>
    <a href="login.php">Cerrar Sesion</a>
    <p id="saldo"> Saldo: ' . $_SESSION["saldo"] . '€';
        } else {
            echo '<a href="cesta.php">Cesta</a>
            <a href="login.php">Login</a>
            <a href="register.php">Registrarse</a>';
        }
        echo '</div>
    </div>';
        ?>
