FROM mysql:8

ADD db-init.sql /docker-entrypoint-initdb.d/