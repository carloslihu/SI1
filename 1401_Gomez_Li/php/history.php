<!DOCTYPE html>
<html>

    <head>
        <?php include 'includes/head.php'; ?>
    </head>

    <body>
        <?php include 'includes/header.php'; ?>

        <div class="row">
            <?php include 'includes/lateral.php'; ?>
            <div class="column middle">
                <?php
                include "includes/utils.php";
                if (isset($_SESSION['username'])) {
                    $path = '../../usuarios/' . $_SESSION['username'] . '/historial.xml';

                    echo '<h2>Perfil del usuario:</h2>';
                    echo '<p><b>Nombre Usuario:</b> ' . $_SESSION['username'] . ' </p>';
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
