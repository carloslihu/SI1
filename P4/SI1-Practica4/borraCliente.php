<?php
define("PGUSER", "alumnodb");
define("PGPASSWORD", "alumnodb");
define("DSN", "pgsql:host=localhost;dbname=si1;options='--client_encoding=UTF8'");
?>
<?php
if (!isset($_REQUEST['submit'])) {
    ?>
    <form action="" method="get">
        customerid<input type="number" name="customerid">
        <br>
        commit intermedio<input type="checkbox" name="commit">
        <br>
        <input type="submit" name="submit" value="Enviar">
    </form>
    <?php
} else {
    try {
        $db = new PDO(DSN, PGUSER, PGPASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        /* Mirar si usar commit intermedio */
        $use_commit = isset($_REQUEST['commit']) ? true : false;        
        
        $db->beginTransaction();
        $sql = "DELETE FROM orderdetail WHERE orderid IN "
                . "(SELECT orderid FROM orders WHERE customerid=" . $_REQUEST['customerid'] . ");";
        $result = $db->exec($sql);

        if ($use_commit) {
            $db->commit();
            $db->beginTransaction();
        }
        /* DESCOMENTAR PARA PROBAR DEADLOCK */
        /*sleep(20);*/
        $sql = "DELETE FROM orders WHERE customerid=" . $_REQUEST['customerid'];
        $result = $db->exec($sql);

        $sql = "DELETE FROM customers WHERE customerid=" . $_REQUEST['customerid'];
        $result = $db->exec($sql);
        
        $db->commit();
        echo '<p><b>Borrado correcto</b></p>';
        echo '<p><a href="borraCliente.php">Nueva consulta</a></p>';
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        $db->rollBack();
    }

    $db = null;
}
?>