SELECT count(orderid) AS cc
FROM customers NATURAL JOIN orders
WHERE totalamount > 100 AND
EXTRACT(MONTH FROM orderdate)=4 AND 
EXTRACT(YEAR FROM orderdate)=2014;


DROP INDEX IF EXISTS idx_customerid_customers;
DROP INDEX IF EXISTS idx_orderdate_orders;
DROP INDEX IF EXISTS idx_totalamount_orders;

--CREATE INDEX idx_customerid_customers ON customers(customerid);
--CREATE INDEX idx_orderdate_orders ON orders(orderdate);
CREATE INDEX idx_totalamount_orders ON orders(totalamount);
ANALYZE orders;
ANALYZE customers;

