<?php
// Start the session
session_start();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include 'includes/head.php';?>
    </head>

    <body>
        <?php include 'includes/header.php';?>

        <div class="row">
            <?php include 'includes/lateral.php';?>
            <div class="column middle">
                <h2>Login</h2>
                <div>

                    <?php
                // define variables and set to empty values
                $username = $password = "";
                $loginErr = "";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(empty($_POST["username"])){
                        $loginErr = "campo usuario vacio";
                    } else {
                        $username = test_input($_POST["username"]);
                        
                    }
                    if(empty($_POST["password"])){
                        $loginErr = "campo contraseña vacio";
                    } else {
                        $password = test_input($_POST["password"]);
                    }
                    //comprueba que existe el usuario
                    if(is_dir("../../usuarios/$username")==FALSE){
                        $loginErr = "Usuario no existente";
                    }else{
                        $userfile=fopen("../../usuarios/$username/datos.dat", "r");
                        //nos saltamos los campos hasta llegar a password
                        fgets($userfile);
                        fgets($userfile);
                        $hash=fgets($userfile);
                        //añado \n para que coincidan passwords
                        if(strcmp($hash, md5($password)."\n") !=0){
                            $loginErr = "contraseña incorrecta";
                        }else{
                            $loginErr = "contraseña correcta";
                        }
                        fclose($userfile);
                    }
                    //TODO javascript to go to another url (index but being logged)
                }

                function test_input($data) {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
                }
                ?>

                        <form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>">

                            <label for="uname">Username</label>
                            <input type="text" id="uname" name="username" placeholder="Tu nombre de usuario o tu e-mail.." value="<?php echo $username;?>" required>

                            <label for="pass">Contrasena</label>
                            <input type="password" id="pass" name="password" placeholder="Tu contrasena.." value="<?php echo $password;?>" required>
                            <span class="error"><?php echo $loginErr; ?></span><br>
                            <input type="submit" value="Login">
                        </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php include 'includes/footer.php';?>
    </body>

    </html>
