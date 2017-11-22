
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
                $conn = pg_connect("host=localhost port=5432 dbname=si1 user=alumnodb password=alumnodb") or die('No pudo conectarse: ' . pg_last_error());
                echo "mae mia que pasa";
                var_dump($conn);
                $xml = simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                if (isset($_REQUEST['search'])) {
                    $filtro = $_REQUEST['filtro'];
                    $search = $search = strtolower($_REQUEST['search']);
                    $films = $xml->xpath("/catalogo/pelicula[./" . $filtro . "[contains(translate(text(), 'ABCDEFGHJIKLMNOPQRSTUVWXYZ', 'abcdefghjiklmnopqrstuvwxyz'), '$search')]]");

                    foreach ($films as $film) {
                        echo '<div class="responsive">';
                        print_film($film);
                        echo '</div>';
                    }
                } else {
                	/*
					foreach ($xml->children() as $films) {
                        echo '<div class="responsive">';
                        print_film($films);
                        echo '</div>';
                	*/
                    //README consulta de las transparencias. A la espera de ver si hay que formatearla mejor o algo para integrarla bien en la pagina web
                    $consulta = 'SELECT * FROM getTopVentas()';
                    var_dump($consulta);
					$resultado = pg_query($conn, $consulta) or die('Consulta fallida: ' . pg_last_error());
					var_dump($resultado);
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
                    }
				pg_close($conn);
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>

    </body>

</html>
