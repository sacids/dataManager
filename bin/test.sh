#! /bin/sh
DB_USER=${DB_USER:-root}

mysql -u $DB_USER -e "DROP DATABASE IF EXISTS afyadata_db_test;"
mysql -u $DB_USER -e "CREATE DATABASE afyadata_db_test;"

CI_ENV=testing php index.php migration latest

php vendor/kenjis/ci-phpunit-test/install.php

cd application/tests/
phpunit --coverage-text

eval "cd ../..; exit $?"
