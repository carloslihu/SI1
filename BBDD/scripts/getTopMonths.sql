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
    (SELECT to_char(orderdate, 'YYYY-MM') as fecha, sum(sales) as ventas 
      FROM inventory
      NATURAL JOIN orderdetail
      NATURAL JOIN orders
      GROUP BY fecha) as sale
  WHERE total >= importe or ventas >= nProducts;
END;
$$ LANGUAGE plpgsql;

--SELECT * FROM getTopMonths(19000, 320000) order by fecha
--query para obtener la ganancia de todos los meses tales que esta sea mayor que <<tal>>
/*SELECT fecha, max(tot) as totalamount from 
  (SELECT to_char(orderdate, 'YYYY-MM') as fecha, sum(totalamount) as tot from orders
  group by to_char(orderdate, 'YYYY-MM')) as b
group by fecha

SELECT setOrderAmount();
  
SELECT EXTRACT (YEAR from orders.orderdate) as yy,
        EXTRACT (MONTH from orders.orderdate) as mm, sum(totalamount) from orders group by yy, mm

--query para obtener el numero de ventas de todos los meses
SELECT fecha, max(sales) as sales from (
SELECT to_char(orderdate, 'YYYY-MM') as fecha, sum(inventory.sales) as sales from orders
NATURAL JOIN orderdetail
NATURAL JOIN inventory
group by to_char(orderdate, 'YYYY-MM')
order by to_char(orderdate, 'YYYY-MM')) as b
group by fecha;
*/