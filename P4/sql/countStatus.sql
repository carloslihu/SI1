 --APARTADO D

 --CONSULTAS
 select count(*)
from orders
where status is null;

select count(*)
from orders
where status ='Shipped';

select count(*)
from orders
where status ='Paid';

select count(*)
from orders
where status ='Processed';

--MI CODIGO
DROP INDEX IF EXISTS idx_status_orders;
CREATE INDEX idx_status_orders ON orders(status);

ANALYZE VERBOSE orders;