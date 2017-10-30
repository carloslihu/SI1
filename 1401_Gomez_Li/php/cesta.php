<!DOCTYPE html>
<html>

<head>
    <?php include 'includes/head.php';?>
</head>

<body>
    <!--   empieza el copypaste-->
    <?php include 'includes/header.php';?>

    <div class="row">
        <?php include 'includes/lateral.php';?>


        <div class="column middle">
            <div>
                <!-- ELEMENTOS DE LA LISTA DE LA COMPRA -->
                <?php
                    //codigo que procesa los post y actua ante ellos:
                    include 'includes/fcesta.php';
                    include 'includes/utils.php';

                    $xml=simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                    var_dump($_POST);
                    if(isset($_POST['comprar']) and isset($_POST['fecha'])){//el usuario ha pedido comprar los productos de su carrito
                        if(isset($_SESSION['username'])){
                            $path = '../../usuarios/'.$_SESSION['username'].'/historial.xml';
                            $history_xml = xml_history_setting($path);
                            foreach ($_SESSION['cesta'] as $id) {
                                add_film_to_history($id, $_POST['fecha'], $history_xml, $path);
                            }
                            clean_cesta();
                        }
                        else{
                            header("Location: login.php");
                        }
                    } else if(isset($_POST['eliminar']))//el usuario ha pedido eliminar un producto de su carrito
                        remove_from_cesta($_POST['eliminar']);

                    //info de la pagina
                    
                    echo '<h2>Cesta</h2>
                            <h1>Total:'.strval(calculate_total($xml)).'</h1>
                            <form method="post" action="cesta.php">
                                <input type="hidden" name="comprar" value="1" />
                                <input type="hidden" id="fecha" name="fecha" value="0/0/0" />
                                <input type="submit" value="comprar" onClick="getDate(\'fecha\');">
                            </form>';

                    foreach($_SESSION['cesta'] as $ids) { 
                        $film = $xml->xpath("/catalogo/pelicula[id='$ids']")[0];

                        echo '<div class="responsive">';
                            print_film($film);
                        echo '<form method="post" action="cesta.php">
                                <input type="hidden" name="eliminar" value="'.$film->id.'" />
                                <input type="submit" value="eliminar">
                            </form>';
                        echo '</div>';
                    } 
                ?>
                <!-- ELEMENTOS DE LA LISTA DE LA COMPRA -->
            </div>

        </div>
    </div>
    <?php include 'includes/footer.php';?>

</body>

</html>
