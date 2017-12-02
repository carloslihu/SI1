--APARTADO C

--A continuación se muestran tres formas alternativas de construir una consulta:
select customerid
from customers
where customerid not in (
	select customerid
 from orders
 where status='Paid'
);

select customerid
from (
 select customerid
 from customers
 union all
 select customerid
 from orders
 where status='Paid'
) as A
group by customerid
having count(*) =1;

select customerid
from customers
except
 select customerid
 from orders
 where status='Paid';

 
--Estudiar, explicar y comparar la planificación de las tres consultas.