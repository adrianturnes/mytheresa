FROM nginx:1.27-alpine

RUN echo "upstream php-upstream { server my-theresa-php:9000; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80
EXPOSE 443
