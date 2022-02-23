FROM nginx:stable-alpine

WORKDIR /etc/nginx/conf.d

COPY config/docker/config/nginx/conf.d/default.conf .

RUN chown -R nobody:nobody /var/log/nginx

EXPOSE 8000