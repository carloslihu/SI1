 --APARTADO D
 select count(*)
from orders
where status is null;

select count(*)
from orders
where status ='Shipped';

--Mio
DROP INDEX IF EXISTS idx_status_orders;
CREATE INDEX idx_status_orders ON orders(status);

ANALYZE orders





--Estudiar, explicar y comparar la planificación de las dos consultas
--• sobre una base de datos limpia (recién creada y cargada de datos),
--• tras crear un índice
--• y tras generar las estadísticas con la sentencia ANALYZE.
--Comparar también con la planificación de las siguientes consultas, una vez generadas las estadísticas:

select count(*)
from orders
where status ='Paid';

select count(*)
from orders
where status ='Processed';

--Ayuda:
--• ¿Qué hace el generador de estadísticas?
--• Usar la sentencia ANALYZE, no VACUUM ANALYZE
--• EXPLAIN ANALYZE no calcula estadísticas. El cálculo de estadísticas se realiza con la
--sentencia ANALYZE