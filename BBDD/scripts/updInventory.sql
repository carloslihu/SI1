CREATE OR REPLACE FUNCTION updInventory() RETURNS TRIGGER AS $$
  BEGIN
    UPDATE inventory AS i
    SET i.sales = i.sales + t.quantity,
      i.stock = i.stock - t.quantity
    FROM (orderdetail NATURAL JOIN i NATURAL JOIN orders) as t
    WHERE NEW.orderid = t.orderid;
  END; $$ LANGUAGE plpgsql;

--toca probarlo  
CREATE TRIGGER t_updInventory AFTER UPDATE ON orders
FOR EACH ROW EXECUTE PROCEDURE updInventory();