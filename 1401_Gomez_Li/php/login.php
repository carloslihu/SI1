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
                <form action="index.php">
                    <label for="uname">Username</label>
                    <input type="text" id="uname" name="username" placeholder="Tu nombre de usuario o tu e-mail..">

                    <label for="pass">Contraseña</label>
                    <input type="password" id="pass" name="password" placeholder="Tu contraseña..">

                    <input type="submit" value="Login">
                </form>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php include 'includes/footer.php';?>
</body>

</html>
