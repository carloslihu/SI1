<div class="column side">
    <h2 class="centerText">Seleccione Categoria</h2>
    <div class="linkButton">

        <form action="index.php" method="post">
            <input type="hidden" name="search" value="">
            <input type="hidden" name="filtro" value="categoria">
            <input type="submit"  value="Destacado"/> 
        </form>
        <form action="index.php" method="post">
            <input type="hidden" name="search" value="aventura">
            <input type="hidden" name="filtro" value="categoria">
            <input type="submit"  value="Aventura"/> 
        </form>
        <form action="index.php" method="post">
            <input type="hidden" name="search" value="misterio">
            <input type="hidden" name="filtro" value="categoria">
            <input type="submit"  value="Misterio"/> 
        </form>
        <form action="index.php" method="post">
            <input type="hidden" name="search" value="fantasía">
            <input type="hidden" name="filtro" value="categoria">
            <input type="submit"  value="Fantasía"/> 
        </form>
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

