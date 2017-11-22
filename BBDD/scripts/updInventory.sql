CREATE OR REPLACE FUNCTION updInventory() RETURNS TRIGGER AS $$
  BEGIN
    UPDATE inventory AS i
    SET i.sales = i.sales + t.quantity,
      i.stock = i.stock - t.quantity
    FROM (orderdetail NATURAL JOIN i NATURAL JOIN orders) as t
    WHERE NEW.orderid = t.orderid;

    /*UPDATE orders
    SET NEW.orderdate = CURRENT_DATE;*/
  END; $$ LANGUAGE plpgsql;

--toca probarlo  
CREATE TRIGGER t_updInventory AFTER UPDATE ON orders --cuando cambie orders.status
FOR EACH ROW 
WHEN (NEW.status IS DISTINCT FROM NULL AND OLD.status = NULL)
EXECUTE PROCEDURE updInventory();

INSERT INTO orders VALUES (200000,CURRENT_DATE,10,2,2,2,NULL);
DELETE FROM orders 
WHERE orderid = 200000;