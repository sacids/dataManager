
mysql -u root -e "DROP DATABASE IF EXISTS afyadata_test;"
mysql -u root -e "CREATE DATABASE afyadata_test;"

set CI_ENV=testing
php index.php migration latest

cd application\tests

phpunit --coverage-text  & cd ../../
