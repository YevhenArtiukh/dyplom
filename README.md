## 1. Zainstalować wszystkie biblioteki
####```composer install```
## 2. W pliku .env wpisać konfiguracje do DB
####```DATABASE_URL=mysql://'login_db':'password_db'@127.0.0.1:3306/'db_name'```
## 3. Stworzyć DB
####```php bin/console doctrine:database:create```
## 4. Stworzyć schemat DB
####```php bin/console make:migration```
## 5. Postawić schemat bazy na tworzoną przez nas DB
####```php bin/console doctrine:migration:migrate```
## 6. Żeby stworzyć użytkownika można wykorzystać następujące polecenie
####```php bin/console doctrine:fixtures:load```
##### login: admin
##### pwd: admin
##### lub wejść na route ````"/registration"````