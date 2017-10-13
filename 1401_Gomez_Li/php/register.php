<!DOCTYPE html>
<html>

<head>
    <?php include 'includes/head.php';?>
    <script type="text/javascript" src="../js/register.js"></script>
    <script>
        function check() {
            if (document.getElementById('pass').value != '' && document.getElementById('pass2').value != '') {
                if (document.getElementById('pass').value == document.getElementById('pass2').value) {
                    document.getElementById('passmsg').style.color = 'green';
                    document.getElementById('passmsg').innerHTML = 'contraseñas coinciden';
                } else {
                    document.getElementById('passmsg').style.color = 'red';
                    document.getElementById('passmsg').innerHTML = 'contraseñas no coinciden';
                }
            } else {
                document.getElementById('passmsg').innerHTML = '';
            }
        }

    </script>
</head>

<body>
    <?php
    //definir variables
    $username = $email = $password = $password2 = $bank_account="";
    $usernameErr = $passwordErr = $registerErr="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username=$_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $bank_account=$_POST["bank_account"];
        
        
        if(is_dir("../../usuarios/$username")==TRUE){
            $usernameErr= 'Usuario ya existe';
        }
        else{
            mkdir("../../usuarios/$username");
            $userfile=fopen("../../usuarios/$username/datos.dat", "x");
            //haremos comprobacion de pass iguales en cliente
            $hash=md5($password);
            $txt = "$username\n$email\n".md5($password)."\n$bank_account\n".rand(0,100);
            fwrite($userfile, $txt);
            fclose($userfile);
            
            $userfile=fopen("../../usuarios/$username/historial.xml", "x");
            fclose($userfile);
            $registerErr="Cuenta creada";
        }
        
        
    }
        
    /*
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }*/
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
                        <span class="error"> <?php echo $usernameErr;?></span>
                        <br>

                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Tu e-mail.." value="<?php echo $email;?>" required>


                        <label for="pass">Contraseña</label>
                        <input type="password" id="pass" name="password" placeholder="Tu contraseña.." value="<?php echo $password;?>" pattern=".{8,}" required title="8 caracteres minimo" onkeyup='check();'>


                        <label for="pass2">Repite tu contraseña</label>
                        <input type="password" id="pass2" name="password2" placeholder="Tu contraseña..." value="<?php echo $password2;?>" pattern=".{8,}" required title="8 caracteres minimo" onkeyup='check();'>
                        <span id='passmsg'></span>
                        <br>

                        <label for="bacc">Cuenta Bancaria</label>
                        <input type="number" id="bacc" name="bank_account" placeholder="Tu cuenta bancaria..." value="<?php echo $bank_account;?>" required>
                        <span class="error"> <?php echo $registerErr;?></span>
                        
                        <input type="submit" value="Registrarse">
                    </form>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <?php include 'includes/footer.php';?>
</body>

</html>
