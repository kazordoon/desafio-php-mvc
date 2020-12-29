#!/bin/bash
docker container exec -i php_login_db mysql -uroot -ptoor < db/dump.sql
