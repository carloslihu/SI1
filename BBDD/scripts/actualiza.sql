--EJECUTAR SCRIPT
--cat actualiza.sql | psql -d si1 -U alumnodb

--CREAR BBDD Y POBLAR
--createdb -U alumnodb si1
--gunzip -c dump_v1.2.sql.gz | psql -U alumnodb si1

--DESTRUIR BBDD
--dropdb -U alumnodb si1

ALTER TABLE orderdetail 
ADD CONSTRAINT orderdetail_orderid_fkey 
FOREIGN KEY (orderid) 
REFERENCES orders (orderid) 
MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE orderdetail 
ADD CONSTRAINT orderdetail_prod_id_fkey
FOREIGN KEY (prod_id) 
REFERENCES products (prod_id)
MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE orders 
ADD CONSTRAINT orders_customerid_fkey
FOREIGN KEY (customerid) 
REFERENCES customers (customerid) 
MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE imdb_actormovies
ADD CONSTRAINT imdb_actormovies_actorid_fkey
FOREIGN KEY (actorid)
REFERENCES imdb_actors (actorid)
MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE imdb_actormovies
ADD CONSTRAINT imdb_actormovies_movieid_fkey
FOREIGN KEY (movieid)
REFERENCES imdb_movies (movieid)
MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE inventory
ADD CONSTRAINT inventory_prod_id_fkey
FOREIGN KEY (prod_id)
REFERENCES products (prod_id)
MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;


--ver repetidos
select orderid,prod_id, count (*)
from orderdetail
group by (orderid,prod_id)
having count(*)>1;
--


--ESTO FUNCIONA, PERO QUITA LOS DUPLICADOS Y EL ORIGINAL
DELETE FROM imdb_movielanguages
WHERE movieid IN (SELECT movieid
              FROM (SELECT movieid,
                             ROW_NUMBER() OVER (partition BY movieid, language ORDER BY movieid) AS rnum
                     FROM imdb_movielanguages) t
              WHERE t.rnum > 1);

DELETE FROM orderdetail
WHERE orderid IN (SELECT orderid
              FROM (SELECT orderid,
                             ROW_NUMBER() OVER (partition BY orderid, prod_id ORDER BY orderid) AS rnum
                     FROM orderdetail) t
              WHERE t.rnum > 1);             
--QUITANDO PRIMARY KEYS
ALTER TABLE imdb_movielanguages
DROP CONSTRAINT imdb_movielanguages_pkey;
ALTER TABLE imdb_movielanguages
ADD CONSTRAINT imdb_movielanguages_pkey PRIMARY KEY (movieid, language);

ALTER TABLE imdb_actormovies
DROP CONSTRAINT imdb_actormovies_pkey;
ALTER TABLE imdb_actormovies
ADD CONSTRAINT imdb_actormovies_pkey PRIMARY KEY (actorid,movieid);
ALTER TABLE imdb_actormovies 
DROP COLUMN numparticipation;

ALTER TABLE imdb_directormovies
DROP CONSTRAINT imdb_directormovies_pkey;
ALTER TABLE imdb_directormovies
ADD CONSTRAINT imdb_directormovies_pkey PRIMARY KEY (directorid,movieid);
ALTER TABLE imdb_directormovies 
DROP COLUMN numpartitipation;

ALTER TABLE orderdetail
ADD CONSTRAINT orderdetail_pkey PRIMARY KEY (orderid,prod_id);

--meter inventory en products


--ENUNCIADO

--Un pedido en curso (cesta o carrito), se caracteriza por tener un valor NULL (valor reservado de
--SQL, no una cadena de caracteres) en la columna status de la tabla orders. Por ello, sólo puede
--haber como máximo un registro de la tabla orders con status NULL para un cliente dado.

--El pedido pasa sucesivamente por los siguientes valores de status: NULL, 'Paid', 'Processed',
--'Shipped'.

--La columna sales de la tabla inventory contiene el número acumulado de artículos vendidos de
--un producto.

--i. claves primarias
--dejar orderdetail.price por comodidad (memoria)


--ii. claves externas 

--iii. qué tablas son entidades, cuáles relaciones y cuáles atributos

--iv. cardinalidad

--v. entidades débiles

--vi. atributos multivaluados

--vii. atributos derivados


--viii. participación total
--es total en este caso 


--mirar uniques y nulls


