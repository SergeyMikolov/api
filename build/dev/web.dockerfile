FROM nginx:1.13.7

ADD vhost.conf /etc/nginx/conf.d/default.conf
