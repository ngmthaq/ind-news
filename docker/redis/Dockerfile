FROM redis:7.2.3-alpine

COPY redis.conf /usr/local/etc/redis/redis.conf

RUN redis-server /usr/local/etc/redis/redis.conf --daemonize yes