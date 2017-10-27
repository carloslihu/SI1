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

            <?php
                echo var_dump($_SESSION['cesta']);
            ?>
            <div>
                <!-- ELEMENTOS DE LA LISTA DE LA COMPRA -->
                <?php
                    $xml=simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                    include 'fcesta.php';
                    echo '<h2>Cesta</h2>
                            <h1>Total:'.strval(calculate_total($xml)).'</h1>
                            <input type="submit" value="Comprar">';
                    foreach($_SESSION['cesta'] as $titles) { 
                        $film = $xml->xpath("/catalogo/pelicula[titulo='$titles']")[0];
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
