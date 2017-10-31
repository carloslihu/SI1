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
                <h2>Producto</h2>
                <?php
                $xml = simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                
                if(!is_numeric($_GET['id'])){
                    echo '<h1>error 404: film nof found</h1>';
                } else {
                    $id = $_GET['id'];
                    $film = $xml->xpath("/catalogo/pelicula[id='$id']")[0];
                    include 'includes/fcesta.php';
                    $confirm_text="";
                    if (isset($_POST['comprar'])) {//si hemor llegado aqui intentando comprar el producto
                        if ($_POST['comprar'] == '1') {
                            $is_valid = is_valid_compra($id);
                            if(!$is_valid){ //añadimos el producto a la cesta
                                $confirm_text="ya tienes este producto";
                            } else if(add_to_cesta($id) == true){//si el error viene dado por intentar añadir a la cesta un producto que ya se compro
                                $confirm_text="producto añadido a la cesta";
                            } else {//si el error viene dado por intentar añadir a la cesta algo que ya estaba añadido
                                $confirm_text="este producto ya estaba en la cesta";
                            }
                            unset($_POST['comprar']); //desactivamos la variable por si el usuario da a f5 (?)
                        }
                    }


                    echo
                    '
                <div class="confirmation_msg">
                    <p>'.$confirm_text.'</p>
                </div>
                <div class="responsive">
                    <div class="gallery">
                        <a href="">
                            <img src=' . $film->poster . ' alt=' . $film->titulo . ' width="100" height="100">
                        </a>
                        <div class="desc">' . $film->titulo . '</div>
                    </div>
                </div>
                <p><b>Descripción: </b><br/>'.$film->descripcion.'</p>
                <p><b>Director: </b>' . $film->director . '</p>
                <p><b>Precio: </b>' . $film->precio . ' €</p>
                <p><b>Categoria: </b>' . $film->categoria . '</p>
                <p><b>Año: </b>' . $film->anno . '</p>
                <p><b>Reparto: </b>' . $film->actores->actor[0]->nombre . '</p>
                <form method="post" action="product.php?id=' . $film->id . '">
                    <input type="hidden" name="comprar" value="1" />
                    <input value="añadir al carro" type="submit"/>
                </form>';
                }
                ?>
                <div class="clearfix"></div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>

    </body>

</html>
