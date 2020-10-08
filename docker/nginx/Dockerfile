FROM nginx:stable-alpine

ADD ./nginx.conf /etc/nginx/nginx.conf
ADD ./default.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/www/html
RUN addgroup -g 1000 idus && adduser -G idus -g idus -s /bin/sh -D idus

RUN chown idus:idus /var/www/html