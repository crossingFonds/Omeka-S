#!/bin/bash
set -e

# app specific setup here
echo "$(hostname -i) $(hostname) $(hostname).localhost" >> /etc/hosts
service sendmail start

apache2-foreground