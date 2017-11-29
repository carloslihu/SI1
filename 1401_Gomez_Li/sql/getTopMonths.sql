--DROP function gettopmonths(integer,numeric);
CREATE OR REPLACE FUNCTION
getTopMonths(nProducts integer, importe numeric)
RETURNS table(fecha text, money numeric, sales2 bigint) AS $$
DECLARE

BEGIN
  RETURN QUERY SELECT * from
    (SELECT to_char(orderdate, 'YYYY-MM') as fecha, 
      sum(totalamount) as total 
      from orders
      GROUP BY fecha) AS amount--calcula fechas e importes acumulados por fecha
  NATURAL JOIN
    (SELECT to_char(orderdate, 'YYYY-MM') as fecha, 
        sum(sales) as ventas 
      FROM inventory
      NATURAL JOIN orderdetail
      NATURAL JOIN orders
      GROUP BY fecha) as sale
  WHERE total >= importe or 
    ventas >= nProducts;
END;
$$ LANGUAGE plpgsql;

--SELECT * FROM getTopMonths(19000, 320000) order by fecha