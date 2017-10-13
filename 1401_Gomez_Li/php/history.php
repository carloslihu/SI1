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
            <h2>Perfil del usuario:</h2>
            <p><b>Nombre Usuario:</b> JavGomez
            </p>
            <p><b>E-mail:</b> carlos.li@estudiante.uam.es
            </p>

            <hr>
            <h2>Historial:</h2>
            <table id="history">
                <tr>
                    <th>Película</th>
                    <th>Precio</th>
                    <th>Fecha</th>

                </tr>
                <tr>
                    <td>
                        <div class="responsive">
                            <div class="gallery">
                                <a href="product.php">
                                    <img alt="Silence of the Lambs" src="../img/SOTL.jpg" width="100" height="100">
                                </a>
                                <div class="desc">
                                    <a href="product.php">
                                        El silencio de los corderos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>10€
                    </td>

                    <td>12-12-2012</td>
                </tr>



                <tr>
                    <td>
                        <div class="responsive">
                            <div class="gallery">
                                <a href="product.php">
                                    <img alt="Jaws" src="../img/JAWS.JPG" width="100" height="100">
                                </a>
                                <div class="desc">
                                    <a href="product.php">
                                        JAWS
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>12€
                    </td>

                    <td>12-12-2012</td>
                </tr>



            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <?php include 'includes/footer.php';?>
</body>

</html>
