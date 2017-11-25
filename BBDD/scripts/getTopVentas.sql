--drop function getTopVentas(integer);
CREATE OR REPLACE FUNCTION
getTopVentas(anno integer)
RETURNS table(fecha double precision, id integer, titulo character varying(255), ventas numeric) AS $$
DECLARE
BEGIN
	
	return query 
    (SELECT f as fecha,imdb_movies.movieid as id, imdb_movies.movietitle as titulo, total3 as ventas
      FROM (
        SELECT f,MAX(total2) as total3
          FROM (
            SELECT f,movieid,SUM(total) as total2
            FROM (
              SELECT EXTRACT(YEAR FROM orderdate) as f, prod_id, SUM(quantity) as total
              FROM orders NATURAL JOIN orderdetail
              where EXTRACT(YEAR FROM orderdate) >= anno
              GROUP BY f, prod_id) AS q--años y productos y cantidad de veces que se vendio en esa fecha
          NATURAL JOIN products
          GROUP BY f, movieid) AS q2
        GROUP BY (f)) AS q3

      NATURAL JOIN

      (
        SELECT f,movieid,SUM(total) as total2
        FROM (
              SELECT EXTRACT(YEAR FROM orderdate) as f, prod_id, SUM(quantity) as total
              FROM orders NATURAL JOIN orderdetail
              where EXTRACT(YEAR FROM orderdate) >= anno
              GROUP BY f, prod_id) AS q--fechas y productos y cantidad de veces que se vendio en esa fecha
          NATURAL JOIN products
          GROUP BY f, movieid) AS q4
      INNER JOIN imdb_movies on q4.movieid = imdb_movies.movieid
      WHERE total2=total3);
END;
$$ LANGUAGE plpgsql;

/*select * from getTopVentas(2011);*/