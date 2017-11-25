--drop function getTopVentas(integer);
CREATE OR REPLACE FUNCTION
getTopVentas(anno integer)
RETURNS table(fecha double precision, movieid integer, ventas numeric) AS $$
DECLARE
BEGIN
	
	return query 

    (SELECT f as fecha,movieid,total3 as ventas
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
          GROUP BY (f,movieid)) AS q2 --años y productos agrupados en sus respectivas peliculas correspondientes (movieid)
        GROUP BY (f)) AS q3 -- año y el maximo de veces que se ha vendido una peli ese año

      NATURAL JOIN

      (
        SELECT f,movieid,SUM(total) as total2
        FROM (
              SELECT EXTRACT(YEAR FROM orderdate) as f, prod_id, SUM(quantity) as total
              FROM orders NATURAL JOIN orderdetail
              where EXTRACT(YEAR FROM orderdate) >= anno
              GROUP BY f, prod_id) AS q
        NATURAL JOIN products
        GROUP BY (f,movieid)) AS q4 --años y productos agrupados en sus respectivas peliculas correspondientes (movieid)
      WHERE total2=total3);
END;
$$ LANGUAGE plpgsql;

/*select * from getTopVentas(2011);*/