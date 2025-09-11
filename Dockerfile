FROM node:24-alpine AS build-vite 

# よくわからないがpnpmが叩けるようになる
ENV PNPM_HOME="/pnpm"
ENV PATH="$PNPM_HOME:$PATH"
RUN corepack enable

WORKDIR /app

COPY package.json pnpm-lock.yaml vite.config.js ./

RUN pnpm install

COPY . .

RUN pnpm run build

FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

COPY --from=build-vite /app/public/build /public/build

# Image config
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Laravel config
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

CMD ["/start.sh"]