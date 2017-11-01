<!DOCTYPE html>
<html>

    <head>
        <?php include 'includes/head.php'; ?>
    </head>

    <body>
        
        <?php
        if (isset($_SESSION["username"])) {
            session_unset();
            session_destroy();
        }
        
        include 'includes/header.php';
        ?>
        <div class="row">
            <?php include 'includes/lateral.php'; ?>
            <div class="column middle">
                <h2>Login</h2>
                <div>

                    <form method="post" action="flogin.php">
                        <label for="uname">Username</label>
                        <input type="text" id="uname" name="username" placeholder="Tu nombre de usuario o tu e-mail.." required value="<?php
                        if (isset($_COOKIE["username"]))
                            echo $_COOKIE["username"];
                        ?>">
                        <label for="pass">Contrasena</label>
                        <input type="password" id="pass" name="password" placeholder="Tu contrasena.." required>
                        <span class="error">
                            <?php print_r($_SESSION["loginErr"]);?>
                        </span><br>

                        <input type="submit" value="Login">
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>
    </body>

</html>
