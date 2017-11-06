psql -U alumnodb si1

ALTER TABLE orderdetail 
ADD CONSTRAINT order_detail_orderid 
FOREIGN KEY (order_id) 
REFERENCES orders 
ON DELETE CASCADE;