#!/bin/bash
set -e

POSTGRES="psql --username ${POSTGRES_USER}"
export PGUSER="$POSTGRES_USER"

for DB in contest_simulator contest_simulator_test ; do
    psql <<-EOSQL
        CREATE USER "$DB" WITH PASSWORD '"$DB"';
        CREATE DATABASE "$DB";
        GRANT ALL PRIVILEGES ON DATABASE "$DB" TO "$DB";
        GRANT ALL PRIVILEGES ON DATABASE "$DB" TO "$POSTGRES_USER";
EOSQL
    psql --dbname="$DB" <<-EOSQL
        CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
        CREATE EXTENSION IF NOT EXISTS postgis;
        CREATE EXTENSION IF NOT EXISTS tablefunc;
EOSQL
done

# disable some data integrity features to greatly improve performance, especially during testing
# should only be used for development
grep -q "fsync = off" /var/lib/postgresql/data/postgresql.conf || echo 'fsync = off' | tee --append /var/lib/postgresql/data/postgresql.conf
grep -q "full_page_writes = off" /var/lib/postgresql/data/postgresql.conf || echo 'full_page_writes = off' | tee --append /var/lib/postgresql/data/postgresql.conf
grep -q "synchronous_commit = off" /var/lib/postgresql/data/postgresql.conf || echo 'synchronous_commit = off' | tee --append /var/lib/postgresql/data/postgresql.conf
