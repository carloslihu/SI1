<?php

/*
 * libera los contenidos de la cesta.
 */

function clean_cesta() {
    unset($_SESSION['cesta']);
    unset($_SESSION['cesta_len']);
}

function hasStock($id){
    try {
            $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            /*                     * * use the database connection ** */
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    $sql = 'SELECT stock FROM inventory WHERE prod_id ='.$id;
    $stock = $db->query($sql)->fetch(PDO::FETCH_OBJ);
    $db = null;
    return ($stock->stock > 0);
}

/*
 * añade el id de una pelicula a la cesta de la compra
 */

function add_to_cesta($id) {
    if (isset($_SESSION['customerid'])) {//si el usuario tiene la sesion iniciada
        try {
                $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
                /*                     * * use the database connection ** */
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        $sql = 'SELECT price FROM products WHERE prod_id = '.$id;
        $price = $db->query($sql)->fetch(PDO::FETCH_OBJ)->price;//TODO control de errores
        $sql = 'INSERT INTO orderdetail(orderid, prod_id, price, quantity) VALUES ('.$_SESSION['orderid'].','.$id.','.$price.',1)';
        $ret = ($db->exec($sql) > 0);
        $db = null;
        return $ret;
    } else {//si el usuario no tenia la sesion iniciada
        if (!in_array($id, $_SESSION['cesta'])) {
            array_push($_SESSION['cesta'], $id);
            return true;
        }
    }
}

/*
 * en caso de que el usuario con sesión iniciada quisiera haber comprado un producto que ya compró con anterioridad, lo elimina de la cesta
 * devuelve true en caso de que tuviera que arreglar la cesta de la compra y false en caso contrario
 */

function fix_cesta() {
    $had_to_fix = false; //se retornara este flag y representa si la cesta tuvo que ser arreglada o no. A priori, es false
    if (!isset($_SESSION['username']) or ! isset($_SESSION['cesta'])) {
        return false;
    }
    /*
      $path = '../../usuarios/' . $_SESSION['username'] . '/historial.xml';
      include_once "utils.php";
      foreach ($_SESSION['cesta'] as $item) {
      if (history_contains_id($path, $item)) {
      remove_from_cesta($item);
      $had_to_fix = true;
      }
      }
     */
    return false;
}

/*
 * en caso de que el usuario quiera comprar algo que ya compro anteriormente, devuelve False
 * devuelve true si se puede añadir el producto a la cesta o si el usuario no ha iniciado sesion
 * devuelve false en caso de que el usuario no pueda añadir el producto debido a que ya compró el producto anteriormente
 */

function is_valid_compra($id) {
    if (!isset($_SESSION['username']))
        return true;
    include_once "utils.php";
    return (!history_contains_id($id));
}

/*
 * elimina un elemento de la cesta de la compra
 */

function remove_from_cesta($id) {
    $i = 0;
    if (isset($_SESSION['orderid'])) {
        try {
            $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            /*             * * use the database connection ** */
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    $db->exec('DELETE FROM orderdetail WHERE prod_id = ' . $id . 'AND orderid = ' . $_SESSION['orderid']); //TODO control de errores (?)
        /* por si habia alguna alerta por este producto */
    $count=$db->exec('DELETE FROM alerts WHERE prod_id = ' . $id . 'AND orderid = ' . $_SESSION['orderid']);
    } else if (isset($_SESSION['cesta'])) {
        foreach ($_SESSION['cesta'] as $product) {
            if ($product == $id) {//si encontramos el elemento lo borramos, arreglamos el array y salimos
                array_splice($_SESSION['cesta'], $i, 1);
                return;
            }
            $i++;
        }
    }
}

/*
 * calcula el precio total de la cesta de la compra
 */

function calculate_total() {
    $total = 0;
    try {
        $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
        /*         * * use the database connection ** */
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    if(isset($_SESSION['orderid'])){
        $total = floatval($db->query('SELECT totalamount FROM orders where orderid = '.$_SESSION['orderid'])->fetch(PDO::FETCH_OBJ)->totalamount);
    } else if(isset($_SESSION['cesta'])){
        foreach ($_SESSION['cesta'] as $id) {
            $total += floatval($db->query('SELECT price FROM products where prod_id = ' . $id)->fetch(PDO::FETCH_OBJ)->price);
            //$total += floatval($film->precio);
        }
    }
    return $total;
}

?>
