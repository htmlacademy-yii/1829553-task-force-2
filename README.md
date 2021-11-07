<p align="center">
    <h1 align="center">Проект TasksForce</h1>
</p>

REQUIREMENTS
------------
Минимальные системные требования PHP8 и MySQL8.0 и выше.

INSTALLATION
------------
Для установки выполнить следующие команды в консоли:

1. скопировать репозиторий
~~~
git clone git@github.com:mar4ehk0/1829553-task-force-2.git taskforce
~~~
2. изменить текущий католог
~~~
cd taskforce
~~~
4. Создать БД tasksforce (Используй различные клиенты для работа с БД)
5. Переименновать файл app/config/db.php.example в db.php
~~~
mv db.php.example db.php
~~~
6. Изменить в файле db.php username и password на реальные значение в вашей БД
~~~
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=taskforce',
    'username' => '@SET_REAL_USERNAME',
    'password' => '@SET_REAL_PASSWORD',
    'charset' => 'utf8',
];    
~~~
7. Создать структы таблиц в БД
~~~
php yii migrate/up
~~~
8. Загрузить подготовленные данные в БД
~~~
php yii fixture/load "*"
~~~
