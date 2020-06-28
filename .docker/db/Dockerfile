FROM postgres:10.11

ENV PG_MAJOR 10
ENV POSTGIS_MAJOR 2.4

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    postgresql-$PG_MAJOR-postgis-$POSTGIS_MAJOR \
    postgresql-$PG_MAJOR-postgis-$POSTGIS_MAJOR-scripts \
    postgis \
    && rm -rf /var/lib/apt/lists/*

# cleanup
RUN apt-get clean autoclean && apt-get autoremove -y

RUN mkdir -p /docker-entrypoint-initdb.d
COPY initdb.sh /docker-entrypoint-initdb.d/
