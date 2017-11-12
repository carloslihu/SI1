UPDATE orderdetail AS od
SET price = p.price - 0.02 * (EXTRACT(YEAR FROM CURRENT_DATE) - EXTRACT(YEAR FROM orderdate)) 
FROM products as p,orders as o
WHERE od.prod_id = p.prod_id AND od.orderid = o.orderid;