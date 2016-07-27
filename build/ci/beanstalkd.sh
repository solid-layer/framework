#!/usr/bin/env bash

(sudo apt-get install -y beanstalkd;sudo service beanstalkd start;beanstalkd -h)
sudo bash -c 'echo "START=yes" >> /etc/default/beanstalkd'
sudo service beanstalkd restart
beanstalkd -v

sleep 5
