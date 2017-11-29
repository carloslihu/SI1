<!DOCTYPE html>
<html>

    <head>
        <?php include 'includes/head.php'; ?>
        <script type="text/javascript" src="../javascript/register.js"></script>
    </head>

    <body>

        <?php
        //definir variables

        $username = $email = $password = $password2 = $bank_account = "";
        $usernameErr = $passwordErr = $registerErr = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $password2 = $_POST["password2"];
            $bank_account = $_POST["bank_account"];
            try {
                $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
                /*                 * * use the database connection ** */
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $sql = "Select customerid from customers
            where email ='" . $email . "'";
            if ($db->query($sql)->rowCount() > 0)
                $usernameErr = 'email ya existe';
            else {
                $sql = "INSERT INTO customers(username,email,password,creditcard,income) VALUES ('$username','$email','" . md5($password) . "',$bank_account," . rand(0, 100) . ");";
                $count = $db->exec($sql);
                if ($count == 0) {
                    $registerErr = "error en register";
                } else {
                    $registerErr = "Cuenta creada, por favor, haga login";
                }
            }
            $db = null;
        }
        ?>
        <?php include 'includes/header.php'; ?>

        <div class="row">
            <?php include 'includes/lateral.php'; ?>
            <div class="column middle">
                <h2>Register</h2>
                <div>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>">
                        <span class="correct"> <?php echo $registerErr; ?></span>
                        <br>
                        <label for="uname">Username</label>
                        <input type="text" id="uname" name="username" placeholder="Tu nombre de usuario.." 
                               value="<?php echo $username; ?>"
                               onkeyup="checkChars();" >
                        
                        

                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Tu e-mail.." value="<?php echo $email; ?>" required>
                        <span id= "userr" class="error"> <?php echo $usernameErr; ?></span>
                        <br>
                        <label for="pass">Contraseña</label>
                        <input type="password" id="pass" name="password" placeholder="Tu contraseña.." value="<?php echo $password; ?>" pattern=".{8,}" required title="8 caracteres minimo" onkeyup='check(); strength()'>
                        <progress id="strength-meter" max="100" value="0"></progress><br>


                        <label for="pass2">Repite tu contraseña</label>
                        <input type="password" id="pass2" name="password2" placeholder="Tu contraseña..." value="<?php echo $password2; ?>" pattern=".{8,}" required title="8 caracteres minimo" onkeyup="check()">
                        <span id='passmsg'></span>
                        <br>

                        <label for="bacc">Cuenta Bancaria</label>
                        <input type="number" id="bacc" name="bank_account" placeholder="Tu cuenta bancaria..." value="<?php echo $bank_account; ?>" required>
                        <input type="submit" value="Registrarse">
                    </form>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </body>

</html>
