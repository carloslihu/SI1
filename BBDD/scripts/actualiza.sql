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
/*
select 
  t.email, 
	count (*)
from customers as t
group by email
having count(*)>1;
*/
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


--QUITANDO NOT NULLS DE ATRIBUTOS DE CUSTOMERS QUE NO QUEREMOS
ALTER TABLE customers ALTER address1 DROP NOT NULL;
ALTER TABLE customers ALTER firstname DROP NOT NULL;
ALTER TABLE customers ALTER lastname DROP NOT NULL;
ALTER TABLE customers ALTER city DROP NOT NULL;
ALTER TABLE customers ALTER country DROP NOT NULL;
ALTER TABLE customers ALTER region DROP NOT NULL;
ALTER TABLE customers ALTER creditcardtype DROP NOT NULL;
ALTER TABLE customers ALTER creditcardexpiration DROP NOT NULL;

ALTER TABLE customers ALTER income SET NOT NULL;
ALTER TABLE customers ALTER COLUMN income TYPE numeric;
ALTER TABLE customers ALTER email SET NOT NULL;
ALTER TABLE customers ADD CONSTRAINT customers_unique UNIQUE(email);

ALTER TABLE orders ALTER orderdate DROP NOT NULL;
ALTER TABLE orders ALTER customerid SET NOT NULL;
ALTER TABLE orders ALTER tax SET DEFAULT 15;



--CONTRASEÑAS EN MD5
UPDATE customers SET password=md5(password);
----------------------------------------------------


--ELIMINAR ROWS DUPLICADOS
DELETE FROM imdb_movielanguages WHERE movieid IN
(SELECT movieid FROM (SELECT movieid, language, COUNT(*) as c FROM imdb_movielanguages
group by movieid, language) AS count_lan WHERE C>1) AND extrainformation='';


--CODIGO PARA JUNTAR FILAS DE ORDERDETAIL DUPLICADOS PARA UN (ORDERID,PROD_ID) FIJO
CREATE TABLE aux (
  orderid integer NOT NULL,
  prod_id integer NOT NULL,
  price numeric default NULL, -- price without taxes when the order was paid
  quantity integer NOT NULL,
  CONSTRAINT orderdetail_orderid_fkey FOREIGN KEY (orderid)
      REFERENCES orders (orderid) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT orderdetail_prod_id_fkey FOREIGN KEY (prod_id)
      REFERENCES products (prod_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

INSERT INTO aux 
(orderid, prod_id, quantity) 
SELECT
  orderid, 
  prod_id, 
  sum(quantity) 
  from orderdetail 
  group by 
    prod_id, 
    orderid;

DROP TABLE orderdetail;
ALTER TABLE aux rename to orderdetail;
--------------------------------------------------------                           
--CAMBIANDO PRIMARY KEYS

ALTER TABLE imdb_actormovies 
DROP COLUMN numparticipation;
ALTER TABLE imdb_actormovies
ADD CONSTRAINT imdb_actormovies_pkey PRIMARY KEY (actorid,movieid);


ALTER TABLE imdb_directormovies 
DROP COLUMN numpartitipation;
ALTER TABLE imdb_directormovies
ADD CONSTRAINT imdb_directormovies_pkey PRIMARY KEY (directorid,movieid);


ALTER TABLE orderdetail
ADD CONSTRAINT orderdetail_pkey PRIMARY KEY (orderid,prod_id);


--------------------------------------------------


--ACTUALIZAR CURRENT VALUE DE SECUENCIAS
SELECT setval('customers_customerid_seq', 
(SELECT MAX(customerid) FROM customers)+1,
 FALSE);
 SELECT setval('imdb_actors_actorid_seq', 
(SELECT MAX(actorid) FROM imdb_actors)+1,
 FALSE);
 SELECT setval('imdb_directormovies_directorid_seq', 
(SELECT MAX(directorid) FROM imdb_directormovies)+1,
 FALSE);
  SELECT setval('imdb_directormovies_movieid_seq', 
(SELECT MAX(movieid) FROM imdb_directormovies)+1,
 FALSE);
  SELECT setval('imdb_directors_directorid_seq', 
(SELECT MAX(directorid) FROM imdb_directors)+1,
 FALSE);
 
  SELECT setval('imdb_moviecountries_movieid_seq', 
(SELECT MAX(movieid) FROM imdb_moviecountries)+1,
 FALSE);
  SELECT setval('imdb_moviegenres_movieid_seq', 
(SELECT MAX(movieid) FROM imdb_moviegenres)+1,
 FALSE);
  SELECT setval('imdb_movies_movieid_seq', 
(SELECT MAX(movieid) FROM imdb_movies)+1,
 FALSE);
  SELECT setval('orders_orderid_seq', 
(SELECT MAX(orderid) FROM orders)+1,
 FALSE);
  SELECT setval('products_movieid_seq', 
(SELECT MAX(movieid) FROM products)+1,
 FALSE);
 SELECT setval('products_prod_id_seq', 
(SELECT MAX(prod_id) FROM products)+1,
 FALSE);
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

--TABLA ALERTAS APARTADO H
CREATE TABLE alerts (
  orderid integer NOT NULL,
  prod_id integer NOT NULL,
  CONSTRAINT alerts_pkey PRIMARY KEY (orderid,prod_id),
  CONSTRAINT alerts_orderid_fkey FOREIGN KEY (orderid)
      REFERENCES orders (orderid) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT alerts_prod_id_fkey FOREIGN KEY (prod_id)
      REFERENCES products (prod_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);