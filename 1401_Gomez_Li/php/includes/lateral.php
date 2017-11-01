<div class="column side">
    <h2>Menu</h2>
    <p>

<a href= "index.php">Destacados</a>
<br>
<a href= "">Aventura</a>
<br>
<a href= "">Misterio</a>
<br>
<a href= "">Fantasía</a>
<br>
    </p>
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

