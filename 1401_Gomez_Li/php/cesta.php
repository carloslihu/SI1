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

                    if(isset($_POST['comprar'])){//el usuario ha pedido comprar los productos de su carrito
                        if(isset($_SESSION['username']))
                            clean_cesta();
                        else
                            header("Location: login.php");
                    } else if(isset($_POST['eliminar']))//el usuario ha pedido eliminar un producto de su carrito
                        remove_from_cesta($_POST['eliminar']);

                    //info de la pagina
                    $xml=simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                    echo '<h2>Cesta</h2>
                            <h1>Total:'.strval(calculate_total($xml)).'</h1>
                            <form method="post" action="cesta.php">
                                <input type="hidden" name="comprar" value="1" />
                                <input type="submit" value="comprar">
                            </form>';
                    foreach($_SESSION['cesta'] as $ids) { 
                        $film = $xml->xpath("/catalogo/pelicula[id='$ids']")[0];
                        echo '<div class="responsive">
                            <div class="gallery">
                                <a href="product.php?title='.$film->titulo.'">
                                <img src='.$film->poster.' alt="imagen" width="100" height="100">
                            </a>
                                <div class="desc">
                                    <a href="product.php?title='.$film->titulo.'">
                                    <b>'.$film->titulo.'</b>
                                </a>
                                    <br>'.$film->director.'</div>
                            </div>
                            <form method="post" action="cesta.php">
                                <input type="hidden" name="eliminar" value="'.$film->id.'" />
                                <input type="submit" value="eliminar">
                            </form>
                        </div>';    
                    } 
                ?>
                <!-- ELEMENTOS DE LA LISTA DE LA COMPRA -->
            </div>

        </div>
    </div>
    <?php include 'includes/footer.php';?>

</body>

</html>
