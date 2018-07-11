FROM ubuntu:16.04

RUN apt-get update && apt-get install -y \
    cron \
    rsyslog \
    nano \
    curl

RUN apt-get install -y software-properties-common \
    && apt-get install -y apt-transport-https
RUN curl -fsSL https://download.docker.com/linux/ubuntu/gpg | apt-key add -
RUN add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"

RUN apt-get update
RUN apt-cache policy docker-ce

RUN apt-get install -y docker-ce

RUN apt-get install -y python-pip && pip install -I docker-compose==1.16.1



COPY cron/crontab /etc/cron.d/crontab
RUN touch /var/log/cron.log
RUN crontab -l | { cat; cat /etc/cron.d/crontab; } | crontab -


#COPY cron/backup.sh /backup.sh
#RUN chmod +x /backup.sh

CMD service rsyslog start \
    && service cron start \
    && tail -f /var/log/cron.log \