
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
                    foreach ($xml->children() as $films) {
                        echo '<div class="responsive">';
                        print_film($films);
                        echo '</div>';
                    }
                }
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>

    </body>

</html>
