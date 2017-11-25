<!DOCTYPE html>
<html>

    <head>
        <?php include 'includes/head.php'; ?>
    </head>

    <body>
        <?php
        include "includes/utils.php";
        if (isset($_POST['saldo']) and is_numeric($_POST['saldo'])) {
            gastar_saldo(-$_POST['saldo']);
            unset($_POST['saldo']);
        }
        include 'includes/header.php';

        echo '<div class="row">';
        include 'includes/lateral.php';
        echo '<div class="column middle">';


        if (isset($_SESSION['username'])) {
            $path = '../../usuarios/' . $_SESSION['username'] . '/historial.xml';

            echo '<h2>Perfil del usuario:</h2>';
            echo '<p><b>Nombre Usuario:</b> ' . $_SESSION['username'] . ' </p>';
            echo '<form method="post" action="' . htmlspecialchars($_SERVER[" PHP_SELF "]) . '">
                        <label for="saldo">añadir saldo</label>
                        <input type="number" step="0.01" id="saldo" name="saldo" placeholder="el saldo" required>
                        <input type="submit" value="añadir saldo">
                      </form>';
            echo '<h2>Historial:</h2>';
            print_history($path);
        }
        ?>
        <div class="clearfix"></div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>

</html>
