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
		UPDATE orders 
    SET netamount = oDetails.precio, 
      totalamount = oDetails.precio + oDetails.precio*orders.tax*0.01
		where oDetails.orderid = orders.orderid and 
      (orders.netamount is null or 
        orders.totalamount is null);
	END LOOP;
END;

$$ LANGUAGE plpgsql;
SELECT setOrderAmount();



/*UPDATE orders SET netamount = NULL*/
