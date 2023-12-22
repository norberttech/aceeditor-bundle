ARG PHP_VERSION=8.1
FROM php:${PHP_VERSION}-cli-alpine3.18

COPY --link --from=composer:2 /usr/bin/composer /usr/bin/

WORKDIR /src
ENTRYPOINT []
CMD ["sh"]
