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
            <h2>Producto</h2>
            <?php 
            $xml=simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
            $titulo=$_REQUEST['title'];
            $film = $xml->xpath("/catalogo/pelicula[titulo='$titulo']")[0];
            
            echo
            '<div class="responsive">
                <div class="gallery">
                    <a href="">
                        <img src='.$film->poster.' alt='.$film->titulo.' width="100" height="100">
                    </a>
                    <div class="desc">'.$film->titulo.'</div>
                </div>
            </div>
            <p><b>Director: </b>'.$film->director .'</p>
            <p><b>Precio: </b>'.$film->precio .' </p>
            <p><b>Categoria: </b>'.$film->categoria  .'</p>
            <p><b>Año: </b>'.$film->anno .'</p>
            <p><b>Reparto: </b>'.$film->actores->actor[0]->nombre .'</p>'
            ?>
            <button type="button">Añadir a Carro!</button>
            <div class="clearfix"></div>
        </div>
    </div>

    <?php include 'includes/footer.php';?>

</body>

</html>
