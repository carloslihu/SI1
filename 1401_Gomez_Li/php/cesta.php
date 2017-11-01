<!DOCTYPE html>
<html>

    <head>
        <?php include 'includes/head.php'; ?>
    </head>

    <body>
        <?php
        //codigo que procesa los post y actua ante ellos:
        include 'includes/fcesta.php';
        include 'includes/utils.php';

        $alert = "";
        if (fix_cesta() == true)
            $alert = "hemos eliminado del carrito algunos productos que ya poseía";

        $xml = simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
        $total = calculate_total($xml);
        if (isset($_POST['comprar']) and isset($_POST['fecha'])) {//el usuario ha pedido comprar los productos de su carrito
            if (isset($_SESSION['username'])) {
                if (!empty($_SESSION['cesta'])) {
                    if (gastar_saldo($total)) {
                        $path = '../../usuarios/' . $_SESSION['username'] . '/historial.xml';
                        $history_xml = xml_history_setting($path);
                        foreach ($_SESSION['cesta'] as $id) {
                            add_film_to_history($id, $_POST['fecha'], $history_xml, $path);
                        }
                        clean_cesta();
                        $alert = "¡Gracias por su compra!";
                        $total = 0;
                    } else {
                        $alert = "no dispones de saldo suficiente!";
                    }
                } else {//en el caso de que la cesta estuviera vacía
                    $alert = "La cesta estaba vacía.";
                }
            } else {
                header("Location: login.php");
            }
        } else if (isset($_POST['eliminar'])) {//el usuario ha pedido eliminar un producto de su carrito
            remove_from_cesta($_POST['eliminar']);
            $total = calculate_total($xml);
        }
        include 'includes/header.php';

        echo '<div class="row">';
        include 'includes/lateral.php';


        echo '<div class="column middle">';
        echo '<div>';

        //info de la pagina

        echo '<h2>Cesta</h2>
                            <p class="confirmation_msg">' . $alert . '</p>
                            <h1>Total:' . strval($total) . ' €</h1>
                            <form method="post" action="cesta.php">
                                <input type="hidden" name="comprar" value="1" />
                                <input type="hidden" id="fecha" name="fecha" value="0/0/0" />
                                <input type="submit" value="comprar" onClick="getDate(\'fecha\');">
                            </form>';

        foreach ($_SESSION['cesta'] as $ids) {
            $film = $xml->xpath("/catalogo/pelicula[id='$ids']")[0];

            echo '<div class="responsive">';
            print_film($film);
            echo '<form method="post" action="cesta.php">
                                <input type="hidden" name="eliminar" value="' . $film->id . '" />
                                <input type="submit" value="eliminar">
                            </form>';
            echo '</div>';
        }
        ?>
        <!-- ELEMENTOS DE LA LISTA DE LA COMPRA -->
    </div>

</div>
</div>
<?php include 'includes/footer.php'; ?>

</body>

</html>
