#!/bin/bash
docker container exec -i mvc_db mysql -uroot -ptoor < db/dump.sql
