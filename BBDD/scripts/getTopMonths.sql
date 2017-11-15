DROP function gettopmonths(integer,numeric);
CREATE OR REPLACE FUNCTION
getTopMonths(nProducts integer, importe numeric)
RETURNS table(y double precision, m double precision) AS $$
DECLARE

BEGIN
  RETURN QUERY SELECT a.yy, a.mm from 
    (SELECT
      EXTRACT (YEAR from orders.orderdate) as yy,
      EXTRACT (MONTH from orders.orderdate) as mm,
      sum(totalamount) as totamount
      from orders
    group by yy, mm) as a
    INNER JOIN 
      (SELECT
        EXTRACT (YEAR from orders.orderdate) as yy,
        EXTRACT (MONTH from orders.orderdate) as mm,
        sum(inventory.sales) as totsales
        from orders
      INNER JOIN orderdetail ON orders.orderid = orderdetail.orderid
      INNER JOIN inventory ON orderdetail.prod_id = inventory.prod_id
      group by mm, yy
      order by yy, mm) as b
    ON a.yy = b.yy and a.mm = a.mm
  where totamount >= importe or totsales >= nProducts
  group by a.yy, a.mm
  order by a.yy, a.mm;
END;
$$ LANGUAGE plpgsql;

SELECT getTopMonths(270000000, 500000)
--query para obtener la ganancia de todos los meses tales que esta sea mayor que <<tal>>
SELECT max(tot) from 
  (SELECT to_char(orderdate, 'YYYY-MM') as fecha, sum(totalamount) as tot from orders
  group by to_char(orderdate, 'YYYY-MM')) as b
where tot > 200000

SELECT EXTRACT (YEAR from orders.orderdate) as yy,
        EXTRACT (MONTH from orders.orderdate) as mm, sum(totalamount) from orders group by yy, mm

--query para obtener el numero de ventas de todos los meses
SELECT max(tot) from (
SELECT to_char(orderdate, 'YYYY-MM') as fecha, sum(inventory.sales) as tot from orders
INNER JOIN orderdetail ON orders.orderid = orderdetail.orderid
INNER JOIN inventory ON orderdetail.prod_id = inventory.prod_id
group by to_char(orderdate, 'YYYY-MM')
order by to_char(orderdate, 'YYYY-MM')) as b
where tot > 340000;
