CREATE OR REPLACE FUNCTION updInventory() RETURNS TRIGGER AS $$
  BEGIN
  IF (OLD.status = NULL) THEN
  --es posible que haya que recorrer de forma extra los diferentes productos de un mismo orderid
    UPDATE inventory
    SET sales = inventory.sales + t.quantity,
      stock = inventory.stock - t.quantity
    FROM (orderdetail NATURAL JOIN inventory NATURAL JOIN orders) as t
    WHERE NEW.orderid = t.orderid;

    UPDATE orders
    SET orderdate = CURRENT_DATE
    WHERE orderid = NEW.orderid;
    
  END IF;
  IF () THEN --necesito ver el stock de los productos a comprar

  END IF;
    --FALTA CONTROL DE ERRORES
    RETURN NEW;
  END; $$ LANGUAGE plpgsql;

--toca probarlo  
DROP TRIGGER IF EXISTS t_updInventory ON orders;

CREATE TRIGGER t_updInventory AFTER UPDATE ON orders 
FOR EACH ROW 
WHEN (NEW.status IS DISTINCT FROM OLD.status)--cuando cambie orders.status(CUANDO PASE DE NULL A ALGO?)

EXECUTE PROCEDURE updInventory();

DELETE FROM orderdetail WHERE orderid = 200000;
DELETE FROM orders WHERE orderid = 200000;
INSERT INTO orders VALUES (200000,CURRENT_DATE,10,2,2,2,NULL);
INSERT INTO orderdetail VALUES (200000, 2, 10, 2);


UPDATE orders SET status = 'Paid' WHERE orderid = 200000;
