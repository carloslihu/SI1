
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
                <h2>Home</h2>

                <div>
                    <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="post">

                        <input type="text" name="search" placeholder="Search..">
                        <select name="filtro">
                            <option value="titulo">titulo</option> 
                            <option value="categoria">categoria</option> 
                            <option value="director">director</option>
                        </select>
                        <input type="submit" value="Search">
                    </form>
                </div>


                <?php
                include "includes/utils.php";
                try {
                    $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
                    /*                     * * use the database connection ** */
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                //TODO eliminar los bloques de codigo antiguo (todo lo referente a xml)
                //$xml = simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                if (isset($_REQUEST['search'])) {
                    
                    $filtro = $_REQUEST['filtro'];
                    $search = $search = strtolower($_REQUEST['search']);
                    if(strcmp($filtro, "titulo") == 0){
                      $sql = 'SELECT prod_id as id, movietitle as titulo, price as precio, string_agg(directorname, \',\') as director
                              FROM Products NATURAL JOIN imdb_movies NATURAL JOIN imdb_directormovies NATURAL JOIN imdb_directors
                              WHERE movietitle ILIKE \'%'.$search.'%\'';
                    } else if(strcmp($filtro, "categoria") == 0){
                      $sql = 'SELECT prod_id as id, movietitle as titulo, price as precio, string_agg(directorname, \',\') as director
                              FROM Products NATURAL JOIN imdb_movies NATURAL JOIN imdb_directormovies NATURAL JOIN imdb_directors
                              NATURAL JOIN imdb_moviegenres NATURAL JOIN imdb_genres
                              WHERE genrename ILIKE \'%'.$search.'%\'';
                    } else {//filtro == director
                      $sql = 'SELECT prod_id as id, movietitle as titulo, price as precio, string_agg(directorname, \',\') as director
                              FROM Products NATURAL JOIN imdb_movies NATURAL JOIN imdb_directormovies NATURAL JOIN imdb_directors
                              WHERE directorname ILIKE \'%'.$search.'%\'
                              GROUP BY id, titulo, precio';
                    }
                    $result = $db->query($sql);
                    if($result){
                      $film = $result->fetch(PDO::FETCH_OBJ);
                      while($film){
                          echo '<div class="responsive">';
                          print_film($film);
                          echo '</div>';
                          $film = $result->fetch(PDO::FETCH_OBJ);
                      }
                    }

                    /*
                    $films = $xml->xpath("/catalogo/pelicula[./" . $filtro . "[contains(translate(text(), 'ABCDEFGHJIKLMNOPQRSTUVWXYZ', 'abcdefghjiklmnopqrstuvwxyz'), '$search')]]");

                    foreach ($films as $film) {
                        echo '<div class="responsive">';
                        print_film($film);
                        echo '</div>';
                    }
                    */
                } else {
                    /*
                      foreach ($xml->children() as $films) {
                      echo '<div class="responsive">';
                      print_film($films);
                      echo '</div>';
                     */
                    //README consulta de las transparencias. A la espera de ver si hay que formatearla mejor o algo para integrarla bien en la pagina web
                    $sql = 'SELECT * FROM getTopVentas('.(date("Y") - 3).')';
                    $resultado = $db->query($sql);
                    while($obj = $resultado->fetch(PDO::FETCH_OBJ)){
                      $sql = 'SELECT prod_id as id, price, string_agg(directorname, \',\') as directorname
                              FROM products NATURAL JOIN imdb_directormovies NATURAL JOIN imdb_directors 
                              WHERE movieid = \''.$obj->id.'\'
                              group by prod_id, price';
                      $subQuery = $db->query($sql);
                      while($prod = $subQuery->fetch(PDO::FETCH_OBJ)){
                        echo '<div class="responsive">';
                        echo '<div class="gallery">
                                <a href="product.php?id=' . $prod->id . '">
                                <img src=' .'../img/murder-on-the-owl-express.jpg'. ' alt="' . $obj->titulo . '" width="100" height="100">
                            </a>
                                <div class="desc abbreviative">
                                    <a href="product.php?id=' . $prod->id . '" title="' . $obj->titulo . '">
                                    <b>' . $obj->titulo . '</b>
                                </a>
                                    <br>by: ' . $prod->directorname . '
                                    <br>price: ' . $prod->price . ' €
                                </div>
                            </div>';
                        echo '</div>';
                      }

                      
                    }
                    /*
                      echo "<table>\n";
                      while ($linea = pg_fetch_array($resultado, null, PGSQL_ASSOC)) {
                      echo "\t<tr>\n";
                      foreach ($linea as $valor_col) {
                      echo "\t\t<td>$valor_col</td>\n";
                      }
                      echo "\t</tr>\n";
                      }
                      echo "</table>\n";
                      pg_free_result($resultado);
                     */
                }
                $db = null;
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>

    </body>

</html>
