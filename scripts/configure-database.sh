#!/bin/bash
docker container exec -i php_login_db mongo -uroot -ptoor --authenticationDatabase admin php_login --eval "
db.users.createIndex({ email: 1 }, { unique: 1 });
db.createUser({ user: 'php', pwd: 'phppass', roles: [ { role: 'readWrite', db: 'php_login' } ] });
"
