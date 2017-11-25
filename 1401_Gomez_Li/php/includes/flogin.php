<?php

session_start();
// define variables and set to empty values
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = test_input($_POST["username"]);
$password = test_input($_POST["password"]);
//comprueba que existe el usuario

try {
    $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
    /*     * * use the database connection ** */
} catch (PDOException $e) {
    echo $e->getMessage();
}
$sql = 'Select * from customers
  where username = \'' . $username . '\' and password = \'' . md5($password) . '\'
  limit 1';
$resultado = $db->query($sql);
$row = $resultado->fetch(PDO::FETCH_OBJ);
if ($resultado->rowCount() == 1) {
    echo 'yes';
    $_SESSION["username"] = $username;
    //expira en 1 dia
    setcookie("username", $username, time() + 86400, "/");
    $_SESSION['saldo'] = $row->income;
    /* TODO CODIGO PARA ESCRIBIR CESTA EN BBDD */

    $sql = "SELECT orderid 
        FROM orders
        WHERE status=NULL AND customerid=" . $row->customerid;
    /* No hay carrito en BBDD */
    if ($db->query($sql) == FALSE) {
        /* creo carrito en BBDD */
        $sql = "INSERT INTO orders(customerid) VALUES (" . $row->customerid . ");";
        $count = $db->exec($sql);
        if ($count < 0)
            echo 'no he creado el carrito bien';
        /* inserto en BBDD lo que haya en cesta */
        /* TODO */
    }else {/* hay carrito en BBDD */
        /* TODO */
        /* escribir en BBDD lo del carrito */

        /* escribir en carrito lo de BBDD cuando existe */

        /* es posible que toque revisar que no esté ya en la BBDD lo del carrito y viceversa */
    }
    header("Location: ../index.php");
} else {
    echo 'no';
    unset($_SESSION['username']);
    $_SESSION["loginErr"] = "contraseña incorrecta";
    header("Location: ../login.php");
}
pg_free_result($resultado);
$db = null;

/*
  //CODIGO ANTIGUO
  if (is_dir("../../../usuarios/$username") == FALSE) {
  $_SESSION["loginErr"] = "no existe el usuario";
  fclose($userfile);
  header("Location: ../login.php");
  } else {
  $userfile = fopen("../../../usuarios/$username/datos.dat", "r");
  //nos saltamos los campos hasta llegar a password
  fgets($userfile);
  fgets($userfile);
  $hash = fgets($userfile);
  //añado \n para que coincidan passwords
  if (strcmp($hash, md5($password) . "\n") != 0) {
  $_SESSION["loginErr"] = "contraseña incorrecta";
  fclose($userfile);
  header("Location: ../login.php");
  } else {
  $_SESSION["username"] = $username;
  //expira en 1 dia
  setcookie("username", $username, time() + 86400, "/");
  //nos saltamos numero cuenta bancaria
  fgets($userfile);
  $_SESSION["saldo"] = fgets($userfile);
  fclose($userfile);
  header("Location: ../index.php");
  }
  }
 */

//TODO javascript to go to another url (index but being logged)
//}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
