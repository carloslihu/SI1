<div class="column side">
    <h2 class="centerText">Seleccione Categoria</h2>
    <div class="linkButton">
    <?php
        try {
            $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            /*                     * * use the database connection ** */
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $result = $db->query('SELECT genrename from imdb_genres group by genrename order by genrename');
        $genre = $result->fetch(PDO::FETCH_OBJ);
        while($genre){
            echo'
                <form action="index.php" method="post">
                    <input type="hidden" name="search" value="'.$genre->genrename.'">
                    <input type="hidden" name="filtro" value="categoria">
                    <input type="submit"  value="'.$genre->genrename.'"/> 
                </form>
                ';
            $genre = $result->fetch(PDO::FETCH_OBJ);
            }
    ?>
    </div>
    <hr> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <div id="anId"></div>
    <script type="text/javascript">
        setInterval(function () {
            $.ajax({url: './generator.php', cache: false, success: function (data) {
                    document.getElementById('anId').innerHTML = "usuarios conectados: \n" + data.foo;
                }, dataType: "json"});
        }, 3000);
    </script>
    <div id="anId"></div>            
</div>  

