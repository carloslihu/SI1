
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
                <?php
                try {
                    $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
                    /*                     * * use the database connection ** */
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                if (!isset($_REQUEST['search'])) {
                    $sql = 'SELECT * FROM getTopVentas(' . (date("Y") - 3) . ')';
                    $resultado = $db->query($sql);
                    echo '<table id="history">
                        <tr>
                        <th>AÑO</th>
                        <th>PELICULA</th>
                        <th>VENTAS</th>
                        </tr>';
                    while ($obj = $resultado->fetch(PDO::FETCH_OBJ)) {

                        echo '<tr>
                        <td>' . $obj->fecha . '</td>
                        <td>' . $obj->titulo . '</td>
                        <td>' . $obj->ventas . '</td>
                        </tr>';
                    }
                    echo '</table>';
                }
                ?>
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


                //TODO eliminar los bloques de codigo antiguo (todo lo referente a xml)
                //$xml = simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                if (isset($_REQUEST['search'])) {

                    $filtro = $_REQUEST['filtro'];
                    $search = $search = strtolower($_REQUEST['search']);
                    if (strcmp($filtro, "titulo") == 0) {
                        $sql = 'SELECT prod_id as id, movietitle as titulo, price as precio, string_agg(directorname, \',\') as director
                              FROM Products NATURAL JOIN imdb_movies NATURAL JOIN imdb_directormovies NATURAL JOIN imdb_directors
                              WHERE movietitle ILIKE \'%'.$search.'%\'
                              GROUP BY id, titulo, precio limit 30';
                    } else if(strcmp($filtro, "categoria") == 0){
                      $sql = 'SELECT prod_id as id, movietitle as titulo, price as precio, string_agg(directorname, \',\') as director
                              FROM Products NATURAL JOIN imdb_movies NATURAL JOIN imdb_directormovies NATURAL JOIN imdb_directors
                              NATURAL JOIN imdb_moviegenres NATURAL JOIN imdb_genres
                              WHERE genrename ILIKE \'%'.$search.'%\'
                              GROUP BY id, titulo, precio limit 30';
                    } else {//filtro == director
                        $sql = 'SELECT prod_id as id, movietitle as titulo, price as precio, string_agg(directorname, \',\') as director
                              FROM Products NATURAL JOIN imdb_movies NATURAL JOIN imdb_directormovies NATURAL JOIN imdb_directors
                              WHERE directorname ILIKE \'%'.$search.'%\'
                              GROUP BY id, titulo, precio limit 30';
                    }
                } else {

                    $sql = 'SELECT prod_id as id, movietitle as titulo, price as precio, string_agg(directorname, \',\') as director
                            FROM Products NATURAL JOIN imdb_movies NATURAL JOIN imdb_directormovies NATURAL JOIN imdb_directors
                            GROUP BY id, titulo, precio
                            limit 30';
                }

                $result = $db->query($sql);
                if ($result) {
                    $film = $result->fetch(PDO::FETCH_OBJ);
                    while ($film) {
                        echo '<div class="responsive">';
                        print_film($film);
                        echo '</div>';
                        $film = $result->fetch(PDO::FETCH_OBJ);
                    }
                }

                $db = null;
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>

    </body>

</html>
