#!/bin/bash

dropdb -U alumnodb si1
createdb -U alumnodb si1
gunzip -c dump_v1.1-P4.sql.gz | psql -U alumnodb si1

# cat scripts/actualiza.sql | psql -d si1 -U alumnodb
# cat scripts/setPrice.sql | psql -d si1 -U alumnodb
# cat scripts/setOrderAmount.sql | psql -d si1 -U alumnodb
# cat scripts/getTopVentas.sql | psql -d si1 -U alumnodb
# cat scripts/getTopMonths.sql | psql -d si1 -U alumnodb
# cat scripts/updOrders.sql | psql -d si1 -U alumnodb
# cat scripts/updInventory.sql | psql -d si1 -U alumnodb