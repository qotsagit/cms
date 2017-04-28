#!/bin/bash

mkdir sql
cd sql
mysqldump --databases qotsa2_cms -uqotsa2 -pfhkhz8536 >cms.sql

cd ..
tar -zcvf update.cms.tar.gz admin ctrls cron libs models sql views alter.php system.config.php
#tar -zcvf install.tar.gz * .htaccess