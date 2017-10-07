<!--Hecho por Javier Gomez y Carlos Li Hu-->
<!DOCTYPE HTML>
<html>

<head>
    <style>
        .error {
            color: #FF0000;
        }

    </style>
</head>

<body>

    <?php
        // define variables and set to empty values
        $nameErr = $ageErr = $genderErr = $studyErr = "";
        $name = $age = $gender = $study = "";   

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit']=="Submit") {

            if (empty($_POST["name"])) {
                $nameErr = "Name is required";
            } else {
                $name = test_input($_POST["name"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                  $nameErr = "Only letters and white space allowed"; 
                }
            }
            if(empty($_POST["age"])){
                $ageErr = "Age is required";
            } else{
                $age=test_input($_POST["age"]);
                if($age <= 0 ){
                    $ageErr = "You should have a positive age"; 
                }
            }

            if (empty($_POST["gender"])) {
                $genderErr = "Gender is required";
            } else {
                $gender = test_input($_POST["gender"]);

            }

            if(empty($_POST["study"])){
                $studyErr = "Response is required";

            } else{
                $study = test_input($_POST["study"]);
            }
        }


        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }
    ?>

        <h2>PHP Form Validation Example</h2>
        <p><span class="error">* required field.</span></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>">

            Name: <input type="text" name="name" value="<?php echo $name;?>">
            <span class="error">* <?php echo $nameErr;?></span>
            <br><br> Age: <input type="number" name="age" value="<?php echo $age;?>">
            <span class="error">* <?php echo $ageErr;?></span>


            <br><br> Gender:
            <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female" ){ echo "checked"; $sr="Srta." ;}?> value="female">Female
            <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male" ){ echo "checked";$sr="Sr." ;}?> value="male">Male
            <span class="error">* <?php echo $genderErr;?></span>
            <br><br> Studies in EPS:
            <input type="radio" name="study" <?php if (isset($study) && $study=="yes" ) echo "checked";?> value="yes">Yes
            <input type="radio" name="study" <?php if (isset($study) && $study=="no" ) echo "checked";?> value="no">No
            <span class="error">* <?php echo $studyErr;?></span>
            <br><br>

            <input type="submit" name="submit" value="Submit">
        </form>

        <h2>Your Response:</h2>
        <?php
        $tit=$titErr="";
        $N=0;
        $M=0;
        
        if($study=="no"){
            echo "Bienvenido $sr $name, debe acceder a la pagina Web de la Universidad para seguir con sus gestiones";
        } else{ 
            echo "Bienvenido $sr $name, Seleccione del siguiente listado el nombre de la titulación que esta cursando";
        ?>
            <!--<form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>">
                    <br><br> Titulaciones:
                    <input type="radio" name="tit" <?php if (isset($tit) && $tit=="inf" ){ echo "checked"; $N=23;}?> value="inf">Ingenieria Informatica
                    <input type="radio" name="tit" <?php if (isset($tit) && $tit=="tele" ){ echo "checked"; $N=22;}?> value="tele">Ingenieria en Telecomunicaciones
                    <input type="radio" name="tit" <?php if (isset($tit) && $tit=="dg" ){ echo "checked"; $N=27;}?> value="dg">Doble Grado en Ingenieria Informatica y Matematicas
                    <span class="error">* <?php echo $titErr;?></span>
                    
                    
                    <br><br>
                    <input type="submit" name="submit" value="Submit2">
                </form>-->

            <!--<?php 
                    if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit']=="Submit2"){
                    $M=$N-$age;
                    echo "Estimado $sr $name. Le informamos que la edad media de finalización de estos estudios es $N años. Puede terminar por tanto en $M años."; } 
        }?>-->

</body>

</html>
