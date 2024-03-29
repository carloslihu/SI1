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

        try {
            $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            /*             * * use the database connection ** */
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $alert = "";
        if (fix_cesta() == true)
            $alert = "hemos eliminado del carrito algunos productos que ya poseía";

        $total = calculate_total();
        if (isset($_POST['comprar']) and isset($_POST['fecha'])) {//el usuario ha pedido comprar los productos de su carrito
            if (isset($_SESSION['username'])) {//obligamos al usuario a hacer login
                //TODO comprobar que existen orderdetails con orderid = $_SESSION['orderid']
                $resultado = $db->query('SELECT * FROM orderdetail where orderid = ' . $_SESSION['orderid'])->fetch();
                if (isset($_SESSION['orderid']) && $resultado) {//comprobamos que el carrito este en base de datos (de lo contrario no existe carrito)
                    if (gastar_saldo($total)) {//gastamos el saldo, marcamos el order como pagado unseteamos orderid
                        if ($db->exec('UPDATE orders set status = \'Paid\' where orderid = ' . $_SESSION['orderid']) == 0) {
                            $alert = "Oooops, something went wrong, try again!";
                        } else {
                            $sql = 'SELECT * FROM alerts WHERE orderid=' . $_SESSION['orderid'];
                            $queryOutput = $db->query($sql);
                            $row = $queryOutput->fetch(PDO::FETCH_OBJ);
                            if ($row) {
                                gastar_saldo(-$total);
                                while ($row) {/* SI HAY ALGUNA ENTRADA EN ALERTS */
                                    $sql2="SELECT movietitle FROM imdb_movies NATURAL JOIN products WHERE prod_id = ".$row->prod_id;
                                    
                                    $alert = 'el producto ' . $db->query($sql2)->fetchObject()->movietitle . ' no tiene stock, por favor, eliminelo';
                                    $row = $queryOutput->fetch(PDO::FETCH_OBJ);
                                }
                            } else {
                                clean_cesta();
                                unset($_SESSION['orderid']);
                                $alert = "¡Gracias por su compra!";
                                $total = 0;
                                //creamos una nueva cesta
                                $sql = "INSERT INTO orders(customerid, netamount, totalamount) VALUES (" . $_SESSION['customerid'] . ",0,0)"; //creo una nueva cesta en la bbdd
                                $count = $db->exec($sql);
                                if ($count <= 0) {//si no se pudo crear el carrito por algun motivo
                                    $alert = 'Ooops, something went wrong. Try again'; //devolvemos un error mediante texto
                                    echo $alert . '<br>';
                                    //header("Location: cesta.php");
                                }
                                //volvemos a buscar el carrito (ahora ya creado)
                                $sql = "SELECT orderid FROM orders WHERE status IS NULL AND customerid = " . $_SESSION['customerid'];
                                $resultado = $db->query($sql);
                                $_SESSION['orderid'] = $resultado->fetch(PDO::FETCH_OBJ)->orderid;
                            }
                        }
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
            remove_from_cesta(intval($_POST['eliminar']));
            $total = calculate_total();
        }
        include 'includes/header.php';

        echo '<div class="row">';
        include 'includes/lateral.php';


        echo '<div class="column middle">';
        echo '<div>';

        //info de la pagina

        echo '<h2>Cesta</h2>
                            <p class="confirmation_msg">' . $alert . '</p>';
        if(isset($_SESSION['orderid']))
            echo '<h1>Total:' . strval($total) . ' €</h1>';
        else
            echo '<h1>Total:' . strval($total) . ' € (without taxes) </h1>';
                            
        echo                '<form method="post" action="cesta.php">
                                <input type="hidden" name="comprar" value="1" />
                                <input type="hidden" id="fecha" name="fecha" value="0/0/0" />
                                <input type="submit" value="comprar" onClick="getDate(\'fecha\');">
                            </form>';

        if (isset($_SESSION['orderid'])) {
            //con esta query obtenemos las pelis del carrito
            $films = $db->query('SELECT movietitle as titulo, description as descr, products.prod_id as id, movieid, orderdetail.price as precio, string_agg(directorname,\',\') as director from orderdetail 
                                INNER JOIN products ON products.prod_id = orderdetail.prod_id
                                NATURAL JOIN imdb_movies NATURAL JOIN (SELECT movieid, directorname FROM imdb_directormovies NATURAL JOIN imdb_directors) AS D
                                where orderid = ' . $_SESSION['orderid'] . '
                                group by movietitle, products.prod_id, descr, movieid, orderdetail.price');
            $film = $films->fetch(PDO::FETCH_OBJ);
            while ($film) {
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
                $film = $db->query('SELECT products.prod_id as id, movietitle as titulo, description as descr, products.price as precio, string_agg(directorname,\',\') as director
                                    FROM products
                                    NATURAL JOIN imdb_movies NATURAL JOIN (SELECT movieid, directorname FROM imdb_directormovies NATURAL JOIN imdb_directors) AS D
                                    WHERE products.prod_id = '.$ids.'
                                    group by movietitle, descr, products.price, id')->fetch(PDO::FETCH_OBJ);
                echo '<div class="responsive">';
                print_film($film);
                echo '<form method="post" action="cesta.php">
                                    <input type="hidden" name="eliminar" value="' . $ids . '" />
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
