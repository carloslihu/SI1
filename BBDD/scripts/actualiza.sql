--COMANDOS DE TERMINAL

--EJECUTAR SCRIPT
--cat actualiza.sql | psql -d si1 -U alumnodb

--CREAR BBDD Y POBLAR
--createdb -U alumnodb si1
--gunzip -c dump_v1.2.sql.gz | psql -U alumnodb si1

--DESTRUIR BBDD
--dropdb -U alumnodb si1

--------------------------------------------------------


--CONSULTA PERSONAL PARA VER CAMPOS REPETIDOS BAJO UN PRIMARY KEY
/*select 
	orderid,
	prod_id, 
	count (*)
from orderdetail
group by (orderid,prod_id)
having count(*)>1;*/
--------------------------------------------------------



--AÑADIR FOREIGN KEYS QUE FALTAN
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
-----------------------------------------------------



--ELIMINAR ROWS DUPLICADOS
--ESTO FUNCIONA, PERO QUITA LOS DUPLICADOS Y EL ORIGINAL

--quitamos los que tienen movieid y language duplicados
DELETE FROM imdb_movielanguages
WHERE movieid IN (
	SELECT movieid
 	FROM (
		SELECT 
			movieid,
		 	ROW_NUMBER() OVER (
		 		partition BY 
		 			movieid, 
		 			language 
		 		ORDER BY movieid
		  	)
		  AS rnum
		  FROM imdb_movielanguages) t
  WHERE t.rnum > 1);
--quitamos orderid y prodid duplicados
DELETE FROM orderdetail
WHERE orderid IN (
	SELECT 
	orderid
  FROM (
  	SELECT 
  		orderid,
      ROW_NUMBER() OVER (
      	partition BY 
      		orderid, 
      		prod_id 
      	ORDER BY orderid) 
      AS rnum
      FROM orderdetail) t
  WHERE t.rnum > 1);
--CODIGO ESTHER

--DELETE FROM imdb_movielanguages WHERE movieid IN
--(SELECT movieid FROM (SELECT movieid, language, COUNT(*) as c FROM imdb_movielanguages
--group by movieid, language) AS count_lan WHERE C>1) AND extrainformation=''

--------------------------------------------------------                           
--QUITANDO PRIMARY KEYS


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
---------------------------------------------------------------------------

--APARTADO B

--creando countries
CREATE SEQUENCE public.imdb_countries_countryid_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE public.imdb_countries_countryid_seq
  OWNER TO alumnodb;

CREATE TABLE imdb_countries(
	countryid integer NOT NULL DEFAULT nextval('imdb_countries_countryid_seq'::regclass),
	countryname character varying(128) NOT NULL,
	CONSTRAINT imdb_countries_pkey PRIMARY KEY (countryid)
);
INSERT INTO imdb_countries(countryname)
(
  SELECT DISTINCT 
    country 
   FROM imdb_moviecountries
);


--modificando moviecountries
ALTER TABLE imdb_moviecountries
ADD COLUMN countryid INTEGER NOT NULL DEFAULT 1;

UPDATE imdb_moviecountries
SET countryid = t1.countryid
FROM imdb_countries as t1
WHERE t1.countryname = country;

ALTER TABLE imdb_moviecountries
DROP COLUMN country;

ALTER TABLE imdb_moviecountries 
ADD CONSTRAINT imdb_moviecountries_countryid_pkey 
PRIMARY KEY(movieid, countryid);

ALTER TABLE imdb_moviecountries 
ADD CONSTRAINT imdb_moviecountries_countryid_fkey 
FOREIGN KEY (countryid) 
REFERENCES imdb_countries (countryid) 
MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;
-----------------------------------------------------

--creando genres
CREATE SEQUENCE public.imdb_genres_genreid_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE public.imdb_genres_genreid_seq
  OWNER TO alumnodb;

CREATE TABLE imdb_genres(
	genreid integer NOT NULL DEFAULT nextval('imdb_genres_genreid_seq'::regclass),
	genrename character varying(128) NOT NULL,
	CONSTRAINT imdb_genres_pkey PRIMARY KEY (genreid)
);

INSERT INTO imdb_genres(genrename)
(
  SELECT DISTINCT 
    genre 
   FROM imdb_moviegenres
);


--modificando moviegenres
ALTER TABLE imdb_moviegenres
ADD COLUMN genreid INTEGER NOT NULL DEFAULT 1;

UPDATE imdb_moviegenres
SET genreid = t1.genreid
FROM imdb_genres as t1
WHERE t1.genrename = genre;

ALTER TABLE imdb_moviegenres
DROP COLUMN genre;

ALTER TABLE imdb_moviegenres 
ADD CONSTRAINT imdb_moviegenres_genreid_pkey 
PRIMARY KEY(movieid, genreid);

ALTER TABLE imdb_moviegenres 
ADD CONSTRAINT imdb_moviegenres_genreid_fkey 
FOREIGN KEY (genreid) 
REFERENCES imdb_genres (genreid) 
MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;
-----------------------------------------------------
--creando languages
CREATE SEQUENCE public.imdb_languages_languageid_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE public.imdb_languages_languageid_seq
  OWNER TO alumnodb;

CREATE TABLE imdb_languages(
	languageid integer NOT NULL DEFAULT nextval('imdb_languages_languageid_seq'::regclass),
	languagename character varying(128) NOT NULL,
	extrainformation character varying(128) NOT NULL,
	CONSTRAINT imdb_languages_pkey PRIMARY KEY (languageid)
);
INSERT INTO imdb_languages(languagename,extrainformation)
(
  SELECT DISTINCT 
    language , extrainformation
   FROM imdb_movielanguages
);


--modificando movielanguages
ALTER TABLE imdb_movielanguages
ADD COLUMN languageid INTEGER NOT NULL DEFAULT 1;

UPDATE imdb_movielanguages
SET languageid = t1.languageid
FROM imdb_languages as t1
WHERE t1.languagename = language;

ALTER TABLE imdb_movielanguages
DROP COLUMN language;
ALTER TABLE imdb_movielanguages
DROP COLUMN extrainformation;

ALTER TABLE imdb_movielanguages 
ADD CONSTRAINT imdb_movielanguages_languageid_pkey 
PRIMARY KEY(movieid, languageid);

ALTER TABLE imdb_movielanguages 
ADD CONSTRAINT imdb_movielanguages_languageid_fkey 
FOREIGN KEY (languageid) 
REFERENCES imdb_languages (languageid) 
MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;
-----------------------------------------------------





--OBSERVACIONES DEL ENUNCIADO

--Un pedido en curso (cesta o carrito), se caracteriza por tener un valor NULL (valor reservado de
--SQL, no una cadena de caracteres) en la columna status de la tabla orders. Por ello, sólo puede
--haber como máximo un registro de la tabla orders con status NULL para un cliente dado.

--El pedido pasa sucesivamente por los siguientes valores de status: NULL, 'Paid', 'Processed',
--'Shipped'.

--La columna sales de la tabla inventory contiene el número acumulado de artículos vendidos de
--un producto.



--OBSERVACIONES PERSONALES
--mirar uniques y nulls
--no meteremos inventory en products porque no todos los products tienen inventory

