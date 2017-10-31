<div class="column side">
    <h2>Menu</h2>
    <pre>
<a href= "">Recientes</a>

<a href= "">Destacados</a>

<a href= "">Accion</a>

<a href= "">Drama</a>

<a href= "">Comedia</a>

...           
    </pre>
    <hr> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <div id="anId"></div>
    <script type="text/javascript">
        setInterval(function () {
            $.ajax({url: './generator.php', cache: false, success: function (data) {
                    document.getElementById('anId').innerHTML = "Numero de usuarios conectados: \n"+data.foo;
                }, dataType: "json"});
        }, 3000);
    </script>
    <div id="anId"></div>            
</div>  

