#!/bin/bash

dropdb -U alumnodb si1
createdb -U alumnodb si1
gunzip -c dump_v1.2.sql.gz | psql -U alumnodb si1
cat sql/actualiza.sql | psql -d si1 -U alumnodb
cat sql/setPrice.sql | psql -d si1 -U alumnodb
cat sql/setOrderAmount.sql | psql -d si1 -U alumnodb
cat sql/getTopVentas.sql | psql -d si1 -U alumnodb
cat sql/getTopMonths.sql | psql -d si1 -U alumnodb
cat sql/updOrders.sql | psql -d si1 -U alumnodb
cat sql/updInventory.sql | psql -d si1 -U alumnodb