<!DOCTYPE html>
<html>

<?php include 'includes/head.php';?>

<body>
    <?php
    //definir variables
    $username = $email = $password = $password2 = $bank_account="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
        <?php include 'includes/header.php';?>

        <div class="row">
            <?php include 'includes/lateral.php';?>
            <div class="column middle">
                <h2>Register</h2>
                <div>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>">
                        <label for="uname">Username</label>
                        <input type="text" id="uname" name="username" placeholder="Tu nombre de usuario.." value="<?php echo $username;?>">



                        <label for="email">E-mail</label>
                        <input type="text" id="email" name="email" placeholder="Tu e-mail.." value="<?php echo $email;?>">


                        <label for="pass">Contraseña</label>
                        <input type="password" id="pass" name="password" placeholder="Tu contraseña.." value="<?php echo $password;?>">


                        <label for="pass2">Repite tu contraseña</label>
                        <input type="password" id="pass2" name="password2" placeholder="Tu contraseña..." value="<?php echo $password2;?>">

                        <label for="bacc">Cuenta Bancaria</label>
                        <input type="number" id="bacc" name="bank_account" placeholder="Tu cuenta bancaria..." value="<?php echo $bank_account;?>">

                        <input type="submit" value="Registrarse">
                    </form>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <?php include 'includes/footer.php';?>
</body>

</html>
