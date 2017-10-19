<?php
echo '<div class="pageTop">
        <div class="header">
            <p class="header_text"><a href="index.php">Tienda de DvDs</a></p>
        </div>
        <div class="topnav">';
if(isset($_SESSION["username"])){
    echo '<a href="cesta.php">Cesta</a>
    <p>'.$_SESSION["username"].'</p>
    <a>Cerrar Sesion<a>';    
}else{

    echo  '<a href="cesta.php">Cesta</a>
            <a href="login.php">Login</a>
            <a href="register.php">Registrarse</a>';
                }
        echo '</div>
    </div>';
?>
