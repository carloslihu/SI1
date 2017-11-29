#!/bin/bash

dropdb -U alumnodb si1
createdb -U alumnodb si1
gunzip -c dump_v1.2.sql.gz | psql -U alumnodb si1
cat scripts/actualiza.sql | psql -d si1 -U alumnodb
