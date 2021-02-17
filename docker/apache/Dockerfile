FROM httpd:2.4.33-alpine
RUN apk update; \
    apk upgrade;

RUN apk add \
    bash \
    apache2 \
    php7-apache2

RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf

# Copy apache vhost file to proxy php requests to php-fpm container
COPY vhost.apache.conf /usr/local/apache2/conf/vhost.apache.conf
RUN echo "Include /usr/local/apache2/conf/vhost.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf
