<?php

session_start();
// define variables and set to empty values
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
$email = test_input($_POST["email"]);
$password = test_input($_POST["password"]);
//comprueba que existe el usuario

try {
    $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
    /*     * * use the database connection ** */
} catch (PDOException $e) {
    echo $e->getMessage();
}
$sql = 'SELECT * FROM customers
  WHERE email = \'' . $email . '\' and password = \'' . md5($password) . '\'
  limit 1';
$resultado = $db->query($sql);
if ($resultado->rowCount() == 1) {
    $row = $resultado->fetch(PDO::FETCH_OBJ);
    //expira en 1 dia
    setcookie("email", $row->email, time() + 86400, "/");
    $_SESSION["username"] = $row->username;
    $_SESSION['saldo'] = $row->income;
    $_SESSION['customerid'] = $row->customerid;
    /* TODO CODIGO PARA ESCRIBIR CESTA EN BBDD */

    $sql = "SELECT orderid 
        FROM orders
        WHERE status is NULL AND customerid=" . $row->customerid;
    $resultado = $db->query($sql);
    if ($resultado == FALSE) {//si no ha cesta en la BBDD
        if(isset($_SESSION['cesta'])){//si hay cesta en la sesion
          $sql = "INSERT INTO orders(customerid) VALUES (" . $row->customerid . ");";//creo una nueva cesta en la bbdd
          $count = $db->exec($sql);
          if ($count < 0)//si no se pudo crear el carrito por algun motivo
              $_SESSION["loginErr"] = 'Ooops, something went wrong. Try again';//devolvemos un error mediante texto
          //volvemos a buscar el carrito (ahora ya creado)
          $sql = "SELECT orderid FROM orders WHERE status is NULL AND customerid=" . $row->customerid;
          $resultado = $db->query($sql);
        }
    }
    //README estos dos condicionales no son mutuamente excluyentes. El primero prepara el estado del sistema para el segundo
    if(isset($_SESSION['cesta'])){//si habia cesta en la base de datos o si habia cesta en local (y por tanto ahora tambien en la base de datos) hacemos merge
      $orderid = $resultado->fetch(PDO::FETCH_OBJ)->orderid;//nos quedamos con el orderid del carrito
      $sql = 'SELECT prod_id from orderdetail where orderid ='.$orderid;
      $resultado = $db->query($sql);
      if($resultado==TRUE){
      $prod_id = $resultado->fetch(PDO::FETCH_OBJ);
      while($prod_id != NULL){
        if(in_array($prod_id, $_SESSION['cesta'])){
          remove_from_cesta($prod_id);
          $prod_id = $resultado->fetch(PDO::FETCH_OBJ);
          //TODO notificar de que se ha eliminado algo de la cesta (?)
        }
        foreach ($_SESSION['cesta'] as $prod_id) {
          //obtenemos el precio de ese prod_id
          $sql = 'SELECT price FROM products WHERE prod_id = '.$prod_id;
          $precio = $db->query($sql)->price;
          $sql = 'INSERT INTO orderdetail(orderid, prod_id, price, quantity) VALUES ('.$orderid.','.$prod_id.','.$precio.',1)';
          $db->exec($sql);
        }
        $_SESSION['orderid'] = $orderid;
      }
      }
    }

    /*PLAN:
      obtener orderid del carrito
      obtener prod_id que hubiera dentro de ese orderid
      eliminar de $_SESSION['cesta'] los prod_id que ya estuvieran en el carrito de la BBDD README luego notificarselo al usuario en la pantalla de login (?)
      debemos escribir los prod_id que quedan en cesta en la BBDD

      QUERIES:
      SELECT orderid from orders where customerid = 6836 and status is null
      SELECT prod_id from orderdetail where orderid = 88699
    */
    
    header("Location: ../index.php");
} else {
    unset($_SESSION['username']);
    $_SESSION["loginErr"] = "invalid username or password";
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
