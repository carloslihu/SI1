CREATE OR REPLACE FUNCTION
setOrderAmount()
RETURNS void AS $$
DECLARE
    oDetails record;
BEGIN
	FOR oDetails in 
	(SELECT orderid, 
    sum(price * quantity) as precio 
    from orderdetail 
    group by orderid)
	LOOP
		UPDATE orders set netamount = oDetails.precio, totalamount = oDetails.precio + oDetails.precio*orders.tax*0.01
		where oDetails.orderid = orders.orderid and (orders.netamount is null or orders.totalamount is null);
	END LOOP;
END;

$$ LANGUAGE plpgsql;
SELECT setOrderAmount();
/*UPDATE orders SET netamount = NULL*/
/*

SELECT * from orders where netamount is not null;
SELECT * from orderdetail where orderid = 113;
SELECT precio from (SELECT orderid as id, sum(price * quantity) as precio from orderdetail group by id) as tabla
SELECT * from orderdetail where orderid = 2026
SELECT orderid, price, quantity from orderdetail where orderid = 181781

UPDATE orders set netamount = 0, totalamount = 00 + 0*orders.tax*0.01 where 181781 = orders.orderid;
SELECT netamount from orders where orderid = 181781;
SELECT * from orders where orderid = 181781;
*/