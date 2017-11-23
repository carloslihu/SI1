--drop function getTopVentas(integer);
CREATE OR REPLACE FUNCTION
getTopVentas(anno integer)
RETURNS table(fecha double precision, id integer, ventas numeric) AS $$
DECLARE
BEGIN
	
	return query 
    (SELECT f as fecha,movieid as id,total3 as ventas
      FROM (
        SELECT f,MAX(total2) as total3
          FROM (
            SELECT f,movieid,SUM(total) as total2
            FROM (
              SELECT EXTRACT(YEAR FROM orderdate) as f, prod_id, SUM(quantity) as total
              FROM orders NATURAL JOIN orderdetail
              where EXTRACT(YEAR FROM orderdate) >= anno
              GROUP BY f, prod_id) AS q--fechas y productos y cantidad de veces que se vendio en esa fecha
          NATURAL JOIN products
          GROUP BY (f,movieid)) AS q2
        GROUP BY (f)) AS q3

      NATURAL JOIN --tabla donde tengo total3 esta con la peli

      (
            SELECT f,movieid,SUM(total) as total2
            FROM (
              SELECT EXTRACT(YEAR FROM orderdate) as f, prod_id, SUM(quantity) as total
              FROM orders NATURAL JOIN orderdetail
              where EXTRACT(YEAR FROM orderdate) >= anno
              GROUP BY f, prod_id) AS q--fechas y productos y cantidad de veces que se vendio en esa fecha
          NATURAL JOIN products
          GROUP BY (f,movieid)) AS q4
      WHERE total2=total3);
END;
$$ LANGUAGE plpgsql;

select * from getTopVentas(2011);


/*select aux.f, ventas.prod_id, aux.max from

  (select f, max(sum) from 

    (select EXTRACT(YEAR FROM orderdate) as f, prod_id, sum(quantity) as sum 
      from (orderdetail
      natural join orders) AS o
      group by f,prod_id) AS v
    
  group by f) as aux

  inner join (
  select EXTRACT(YEAR FROM orders.orderdate) as f, prod_id, sum(quantity) 
    from orderdetail
    natural join orders
    group by f,prod_id) as ventas
  on ventas.f = aux.f and ventas.sum = aux.max
*/
SELECT f,movieid,total3
FROM (
  SELECT f,MAX(total2) as total3
    FROM (
      SELECT f,movieid,SUM(total) as total2
      FROM (
        SELECT EXTRACT(YEAR FROM orderdate) as f, prod_id, SUM(quantity) as total
        FROM orders NATURAL JOIN orderdetail
        GROUP BY f, prod_id) AS q--fechas y productos y cantidad de veces que se vendio en esa fecha
    NATURAL JOIN products
    GROUP BY (f,movieid)) AS q2
  GROUP BY (f)) AS q3

NATURAL JOIN --tabla donde tengo total3 esta con la peli

(
      SELECT f,movieid,SUM(total) as total2
      FROM (
        SELECT EXTRACT(YEAR FROM orderdate) as f, prod_id, SUM(quantity) as total
        FROM orders NATURAL JOIN orderdetail
        GROUP BY f, prod_id) AS q--fechas y productos y cantidad de veces que se vendio en esa fecha
    NATURAL JOIN products
    GROUP BY (f,movieid)) AS q4
WHERE total2=total3;    
  

(select EXTRACT(YEAR FROM orders.orderdate) as f from orders group by f)

select prod_id, quantity from orderdetail
    inner join orders on orderdetail.orderid = orders.orderid and
      EXTRACT(YEAR FROM orders.orderdate) = 2013
      
select prod_id, sum(quantity) as num from orderdetail
    inner join orders on orderdetail.orderid = orders.orderid and
      EXTRACT(YEAR FROM orders.orderdate) = 2013
    group by prod_id
    order by num desc limit 1

 select imdb_movies.movietitle from imdb_movies, products
  where products.prod_id = 5227 and imdb_movies.movieid = products.movieid

--numero de veces que se vende el producto mas vendido de 2013

/*


SELECT EXTRACT(YEAR FROM orderdate) FROM orders WHERE orderdate >= '2008-1-1'::date group by EXTRACT(YEAR FROM orderdate) order by EXTRACT(YEAR FROM orderdate) desc



SELECT distinct EXTRACT(YEAR FROM orderdate), imdb_movies.movietitle, max(inventory.sales) from orders
INNER JOIN orderdetail ON orders.orderid = orderdetail.orderid
INNER JOIN inventory ON inventory.prod_id = orderdetail.prod_id
INNER JOIN products ON products.prod_id = orderdetail.prod_id
INNER JOIN imdb_movies ON imdb_movies.movieid = products.movieid
where EXTRACT(YEAR FROM orderdate) >= 2008 group by EXTRACT(YEAR FROM orderdate), imdb_movies.movietitle order by EXTRACT(YEAR FROM orderdate) desc

SELECT prod_id from orderdetail where 
*/