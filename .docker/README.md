## Dev

Cборка образов:

    cd .docker/app/php-7.4
    docker build -t car-service-main .

    cd .docker/app/php-7.4/dev
    docker build -t car-service-dev .

    cd .docker/nginx
    docker build --no-cache -t car-service-nginx .
