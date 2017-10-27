
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
                    <form action="" method="post">

                        <input type="text" name="search" placeholder="Search..">
                        <select name="filtro">
                            <option value="0">Seleccionar...</option> 
                            <option value="1">Pelicula</option> 
                            <option value="2">Genero</option> 
                            <option value="3">Director</option>
                        </select>
                        <input type="submit" value="search">
                    </form>
                </div>


                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                }
                $xml = simplexml_load_file("../xml/catalogo.xml") or die("Error: Cannot create object");
                include 'includes/utils.php';
                foreach ($xml->children() as $films) {
                    print_film($films);
                }
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>

    </body>

</html>
