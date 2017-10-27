
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
                        <input type="submit" value="submit">
                    </form>
                </div>


                <?php
                $xml = simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                if (isset($_REQUEST['search'])) {
                    echo 'estoy dentro';
                    $filtro = $_REQUEST['filtro'];
                    $search = $_REQUEST['search'];
                    echo $search . '     ' . $filtro;
                    $films = $xml->xpath("/catalogo/pelicula['.$filtro.'='.$search.']");
                    foreach ($films as $film) {
                        echo '<div class="responsive">
                    <div class="gallery">
                        <a href="product.php?id=' . $film->id . '">
                        <img src=' . $film->poster . ' alt="imagen" width="100" height="100">
                    </a>
                        <div class="desc">
                            <a href="product.php?id=' . $film->id . '">
                            <b>' . $film->titulo . '</b>
                        </a>
                            <br>' . $film->director . '</div>
                    </div>
                </div>';
                    }
                } else {
                    foreach ($xml->children() as $films) {
                        echo '<div class="responsive">
                    <div class="gallery">
                        <a href="product.php?id=' . $films->id . '">
                        <img src=' . $films->poster . ' alt="imagen" width="100" height="100">
                    </a>
                        <div class="desc">
                            <a href="product.php?id=' . $films->id . '">
                            <b>' . $films->titulo . '</b>
                        </a>
                            <br>' . $films->director . '</div>
                    </div>
                </div>';
                    }
                }
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>

    </body>

</html>
