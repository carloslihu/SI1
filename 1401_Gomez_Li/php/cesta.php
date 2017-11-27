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
            $total = calculate_total();
        }
        include 'includes/header.php';

        echo '<div class="row">';
        include 'includes/lateral.php';


        echo '<div class="column middle">';
        echo '<div>';

        //info de la pagina
        var_dump($_SESSION['orderid']);
        var_dump($total);

        echo '<h2>Cesta</h2>
                            <p class="confirmation_msg">' . $alert . '</p>
                            <h1>Total:' . strval($total) . ' €</h1>
                            <form method="post" action="cesta.php">
                                <input type="hidden" name="comprar" value="1" />
                                <input type="hidden" id="fecha" name="fecha" value="0/0/0" />
                                <input type="submit" value="comprar" onClick="getDate(\'fecha\');">
                            </form>';

        try {
            $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            /*                     * * use the database connection ** */
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if(isset($_SESSION['orderid'])){
            //con esta query obtenemos las pelis del carrito
            $films = $db->query('SELECT movietitle as titulo, products.prod_id as id, movieid, orderdetail.price as precio, array_agg(directorname) as directors from orderdetail 
                                INNER JOIN products ON products.prod_id = orderdetail.prod_id
                                NATURAL JOIN imdb_movies NATURAL JOIN (SELECT movieid, directorname FROM imdb_directormovies NATURAL JOIN imdb_directors) AS D
                                where orderid = '.$_SESSION['orderid'].'
                                group by movietitle, products.prod_id, movieid, orderdetail.price');
            $film = $films->fetch(PDO::FETCH_OBJ);
            while($film){
                echo '<div class="responsive">';
                print_film($film);
                echo '<form method="post" action="cesta.php">
                                    <input type="hidden" name="eliminar" value="' . $film->id . '" />
                                    <input type="submit" value="eliminar">
                                </form>';
                echo '</div>';
                $film = $films->fetch(PDO::FETCH_OBJ);
            }

        } else {
            foreach ($_SESSION['cesta'] as $ids) {//TODO
                $film = $db->query('SELECT movietitle as titulo, products.price as precio, array_agg(directorname) as directores FROM orderdetail
                            INNER JOIN products ON products.prod_id = orderdetail.prod_id
                            NATURAL JOIN imdb_movies NATURAL JOIN (SELECT movieid, directorname FROM imdb_directormovies NATURAL JOIN imdb_directors) AS D
                            WHERE orderdetail.prod_id = '.$ids.' 
                            group by movietitle, products.price')->fetch(PDO::FETCH_OBJ);
                echo '<div class="responsive">';
                print_film($film);
                echo '<form method="post" action="cesta.php">
                                    <input type="hidden" name="eliminar" value="' . $film->id . '" />
                                    <input type="submit" value="eliminar">
                                </form>';
                echo '</div>';
            }
        }
        ?>
        <!-- ELEMENTOS DE LA LISTA DE LA COMPRA -->
    </div>

</div>
</div>
<?php include 'includes/footer.php'; ?>

</body>

</html>
