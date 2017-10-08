<!DOCTYPE html>
<html>

<?php include 'includes/head.php';?>

<body>
    <?php include 'includes/header.php';?>

    <div class="row">
        <?php include 'includes/lateral.php';?>


        <div class="column middle">
            <h2>Home</h2>

            <div>
                <input type="text" name="search" placeholder="Search..">
                <div class="dropdown">

                    <button class="dropbtn">Filtro</button>
                    <div class="dropdown-content">
                        <form>
                            <input type="radio" name="filtro" value="pelicula"> pelicula<br>
                            <input type="radio" name="filtro" value="genero"> genero<br>
                            <input type="radio" name="filtro" value="director"> director
                        </form>
                    </div>

                </div>
            </div>


            <div class="responsive">
                <div class="gallery">
                    <a href="product.php">
                        <img src="../img/JAWS.JPG" alt="JAWS" width="100" height="100">
                    </a>
                    <div class="desc">
                        <a href="product.php">
                            <b>Jaws</b>
                        </a>
                        <br> Steven Spielberg</div>
                </div>
            </div>



            <div class="responsive">
                <div class="gallery">
                    <a href="product.php">
                        <img src="../img/FC.jpg" alt="FC" width="100" height="100">
                    </a>
                    <div class="desc">
                        <a href="product.php">
                            <b>Fight Club</b><br>
                        </a>
                        David Fincher
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php include 'includes/footer.php';?>

</body>

</html>
