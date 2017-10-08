<!DOCTYPE html>
<html>

<?php include 'includes/head.php';?>

<body>
    <!--   empieza el copypaste-->
    <?php include 'includes/header.php';?>

    <div class="row">
        <?php include 'includes/lateral.php';?>


        <div class="column middle">
            <h2>Cesta</h2>
            <h1>Total: 20€</h1>
            <input type="submit" value="Comprar">

            <div>
                <!-- ELEMENTOS DE LA LISTA DE LA COMPRA -->
                <div class="responsive">
                    <div class="gallery">
                        <a href="product.php">
                            <img src="../img/JAWS.JPG" alt="Trolltunga Norway" width="100" height="100">
                        </a>
                        <div class="desc">
                            <a href="product.php">
                                <b>Jaws</b>
                            </a>
                            <br> Steven Spielberg
                            <br> 10 €
                            <input type="submit" value="eliminar">
                        </div>
                    </div>
                </div>
                <div class="responsive">
                    <div class="gallery">
                        <a href="product.php">
                            <img src="../img/JAWS.JPG" alt="Trolltunga Norway" width="100" height="100">
                        </a>
                        <div class="desc">
                            <a href="product.php">
                                <b>Jaws</b>
                            </a>
                            <br> Steven Spielberg
                            <br> 10€
                            <input type="submit" value="eliminar">
                        </div>
                    </div>
                </div>
                <!-- ELEMENTOS DE LA LISTA DE LA COMPRA -->
            </div>

        </div>
    </div>
    <?php include 'includes/footer.php';?>

</body>

</html>
