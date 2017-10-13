<!DOCTYPE html>
<html>

<?php include 'includes/head.php';?>

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
                $loginERR = "";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(empty($_POST["username"])){
                        $loginERR = "usuario o contrasena incorrectos";
                    } else {
                        $username = test_input($_POST["username"]);
                    }
                    if(empty($_POST["password"])){
                        $loginERR = "usuario o contrasena incorrectos";
                    } else {
                        $password = test_input($_POST["password"]);
                    }
                    //TODO check if password & username match
                    //TODO javascript to go to another url (index but being logged)
                }

                function test_input($data) {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
                }
                ?>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <span class="error">*<?php echo $loginERR; ?></span><br>
                    <label for="uname">Username</label>
                    <input type="text" id="uname" name="username" placeholder="Tu nombre de usuario o tu e-mail..">

                    <label for="pass">Contrasena</label>
                    <input type="password" id="pass" name="password" placeholder="Tu contrasena..">

                    <input type="submit" value="Login">
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php include 'includes/footer.php';?>
</body>

</html>
