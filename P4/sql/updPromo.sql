ALTER TABLE customers ADD COLUMN promo numeric;

CREATE OR REPLACE FUNCTION updPromo() RETURNS TRIGGER AS $$
  BEGIN
    PERFORM pg_sleep(30);
    UPDATE orderdetail 
    SET price = p.price * (1 - NEW.promo * 0.01)
    FROM products AS p, orders AS o
    WHERE NEW.customerid = o.customerid AND 
    o.orderid=orderdetail.orderid AND 
    orderdetail.prod_id=p.prod_id;

    RETURN NEW;
  END; $$ LANGUAGE plpgsql;

--DROP TRIGGER IF EXISTS t_updPromo ON customers;

CREATE TRIGGER t_updPromo AFTER UPDATE ON customers 
FOR EACH ROW 
WHEN (NEW.promo IS DISTINCT FROM OLD.promo)
EXECUTE PROCEDURE updPromo();

UPDATE customers
SET promo=50
WHERE customerid=3;
/*


SELECT * FROM orderdetail WHERE orderid IN(
SELECT orderid FROM orders
WHERE customerid=1);

SELECT price FROM products WHERE prod_id=1256;
*/
UPDATE orders
SET status=NULL;
SELECT orderid FROM orders WHERE customerid=1;

