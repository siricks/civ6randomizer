Запустить серв
php bin/console server:run

Создать CRUD
php bin/console make:crud

Создать класс / Добавить поле (обновить класс)
php bin/console make:entity

Создать миграцию
php bin/console make:migration

Закачать миграцию в БД
php bin/console doctrine:migrations:migrate

БД
Создать БД
php bin/console doctrine:database:create

Удалить БД
php bin/console doctrine:database:drop --force

Фикстуры
Создать пустой класс фикстур
bin/console make:fixtures

Загрузить фикстуры
php bin/console doctrine:fixtures:load

Создать контроллер
php bin/console make:controller

**Продакшн окружение**

Чистить кэш
php bin/console cache:clear

Создать env для прода
composer dump-env prod


Composer commands
Установить фикстуры
composer require --dev doctrine/doctrine-fixtures-bundle

Создать хэш пароля
php bin/console security:encode-password

Установить банд безопасности
(https://symfony.com/doc/current/security.html#security-authorization-access-control)
composer require symfony/security-bundle

Сгенерить форму входа 
(https://symfony.com/doc/current/security/form_login_setup.html)
php bin/console make:auth

**Сервер Бегета**

Зайти и почистить кэш

sshpass -p 'G0Vn0Eb@n0e' ssh webideeb:@webideeb.beget.tech "cd guns.web-iden.ru/public_html/civ6 && php7.2 bin/console cache:clear && exit"

Зайти и провести миграцию

sshpass -p 'G0Vn0Eb@n0e' ssh webideeb:@webideeb.beget.tech "cd guns.web-iden.ru/public_html/civ6 && php7.2 bin/console doctrine:migrations:migrate && exit"
