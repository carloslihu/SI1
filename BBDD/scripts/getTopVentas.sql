drop function getTopVentas(integer);
CREATE OR REPLACE FUNCTION
getTopVentas(anno integer)
RETURNS table(a integer,b bigint ) AS $$
DECLARE
	annos integer;
BEGIN
	
	FOR annos IN select extract (year from orders.orderdate) as fecha from orders
    where extract (year from orders.orderdate) >= anno
    group by fecha
	LOOP
		return query select prod_id, sum(quantity) from orderdetail
    inner join orders on orderdetail.orderid = orders.orderid and
      EXTRACT(YEAR FROM orders.orderdate) = annos
    group by prod_id
    order by sum desc limit 1;
	END LOOP;
END;
$$ LANGUAGE plpgsql;

select * from getTopVentas(1998);



sumQuantity*ventasProd

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