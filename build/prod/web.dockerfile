FROM nginx:1.13

ADD nginx/nginx.conf   /etc/nginx/nginx.conf
ADD nginx/vhost.conf   /etc/nginx/conf.d/default.conf