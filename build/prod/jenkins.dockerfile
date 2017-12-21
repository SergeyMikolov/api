FROM jenkinsci/blueocean

USER root

RUN apk add py-pip && pip install -I docker-compose==1.16.1