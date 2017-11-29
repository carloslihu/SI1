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
                <?php
                //$xml = simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                if (!is_numeric($_GET['id'])) {
                    echo '<h1>error 404: film not found</h1>';
                } else {
                    try {
                        $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
                        /*                     * * use the database connection ** */
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    $id = $_GET['id'];
                    //README datos que necesitamos del producto
                    // titulo, imagen, descripcion, director, precio, categoria, anno, actores, 
                    /* QUERYS:
                    SELECT movieid, description, price from products where prod_id = 103
                    SELECT movietitle from imdb_movies where movieid = 7969
                    SELECT genrename from imdb_genres natural join imdb_moviegenres where movieid = 7969
                    SELECT actorname from imdb_actors natural join imdb_actormovies where movieid = 7969
                    SELECT directorname from imdb_directors natural join imdb_directormovies where movieid = 7969
                    */
                    $sql = 'SELECT movieid, description, price from products where prod_id = '.$id;
                    $queryMovie = $db->query($sql);
                    $movie = $queryMovie->fetch(PDO::FETCH_OBJ);
                    //$film = $xml->xpath("/catalogo/pelicula[id='$id']")[0];
                    if (!$queryMovie) {
                        echo '<h1>error 404: film not found</h1>';
                        return;
                    } else {
                        include 'includes/fcesta.php';
                        $confirm_text = "";
                        if (isset($_POST['comprar'])) {//si hemor llegado aqui intentando comprar el producto
                            if ($_POST['comprar'] == '1') {
                                $is_valid = is_valid_compra($id);
                                if (!$is_valid) { //añadimos el producto a la cesta
                                    $confirm_text = "ya tienes este producto";
                                } else if(hasStock($id)){
                                    if (add_to_cesta($id) == true) {//si el error viene dado por intentar añadir a la cesta un producto que ya se compro
                                        $confirm_text = "producto añadido a la cesta";
                                    } else {//si el error viene dado por intentar añadir a la cesta algo que ya estaba añadido
                                        $confirm_text = "este producto ya estaba en la cesta";
                                    }
                                } else {
                                    $confirm_text = "no quedan ejemplares de este producto";
                                }
                                unset($_POST['comprar']); //desactivamos la variable por si el usuario da a f5 (?)
                            }
                        }
                    }
                    $sql = 'SELECT movietitle from imdb_movies where movieid = '.$movie->movieid;
                    $queryTitulo = $db->query($sql);
                    $titulo = $queryTitulo->fetch(PDO::FETCH_OBJ);
                    $sql = 'SELECT genrename from imdb_genres natural join imdb_moviegenres where movieid = '.$movie->movieid.'limit 5';
                    $queryGeneros = $db->query($sql);
                    $sql = 'SELECT actorname from imdb_actors natural join imdb_actormovies where movieid = '.$movie->movieid.'limit 5';
                    $queryActores = $db->query($sql);
                    $sql = 'SELECT directorname from imdb_directors natural join imdb_directormovies where movieid = '.$movie->movieid.'limit 5';
                    $queryDirectores = $db->query($sql);

                    

                    echo
                    '
                    <h1>' . $titulo->movietitle . '</h1>
                    <p class="confirmation_msg">' . $confirm_text . '</p>
                <div class="responsive">
                    <div class="gallery">
                        <a href="">
                            <img src=' . '../img/murder-on-the-owl-express.jpg' . ' alt="' . $titulo->movietitle . '"" width="100" height="100">
                        </a>
                        <div class="desc">' . $titulo->movietitle . '</div>
                    </div>
                </div>
                <p><b>Descripción: </b><br/>' . $movie->description . '</p>';
                echo'<p><b>Directors: </b><br/>';
                while($directores = $queryDirectores->fetch(PDO::FETCH_OBJ))
                    echo $directores->directorname . '<br/>';
                echo'</p>';
                echo '<p><b>Price: </b>' . $movie->price . ' €</p>';
                echo'<p><b>Categories: </b><br/>';
                while($genero = $queryGeneros->fetch(PDO::FETCH_OBJ))
                    echo $genero->genrename . '<br/>';
                echo'</p>';
                echo '<p><b>casting:</b><br/>';
                while($actores = $queryActores->fetch(PDO::FETCH_OBJ))
                    echo $actores->actorname . '<br/>';
                echo '</p>
                <form method="post" action="product.php?id=' . $id . '">
                    <input type="hidden" name="comprar" value="1" />
                    <input value="añadir al carro" type="submit"/>
                </form>';
                $db = null;
                }
                ?>
                <div class="clearfix"></div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>

    </body>

</html>
