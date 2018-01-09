FROM ubuntu:16.04

RUN apt-get update && apt-get install -y \
    cron \
    rsyslog \
    nano \
    curl

COPY crontab /etc/cron.d/crontab
RUN touch /var/log/cron.log
RUN cat /etc/cron.d/crontab | crontab -

CMD service rsyslog start \
    && service cron start \
    && tail -f /var/log/cron.log \
    && tail -f /var/log/syslog