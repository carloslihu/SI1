CREATE OR REPLACE FUNCTION
getTopVentas(anno integer)
RETURNS table(año double precision, pelicula varchar(255), ventas integer) AS $$
DECLARE
	annos integer;
BEGIN
	
	FOR annos IN SELECT EXTRACT(YEAR FROM orderdate) FROM orders WHERE EXTRACT(YEAR FROM orderdate) >= anno 
			group by EXTRACT(YEAR FROM orderdate) order by EXTRACT(YEAR FROM orderdate) desc
	LOOP
		return query SELECT EXTRACT(YEAR FROM orderdate) as año, imdb_movies.movietitle as pelicula, inventory.sales as ventas from orders /*where orderdate >= '2008-1-1'::date*/
		INNER JOIN orderdetail ON orders.orderid = orderdetail.orderid
		INNER JOIN inventory ON inventory.prod_id = orderdetail.prod_id
		INNER JOIN products ON products.prod_id = orderdetail.prod_id
		INNER JOIN imdb_movies ON imdb_movies.movieid = products.movieid
		where EXTRACT(YEAR FROM orderdate) = annos order by inventory.sales desc limit 1;
	END LOOP;
END;
$$ LANGUAGE plpgsql;



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