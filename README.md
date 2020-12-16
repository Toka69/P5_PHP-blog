# P5 PHP_Blog

As part of my diploma course as a PHP / Symfony developer via OpenClassrooms, this is my work for project n ° 5.
It is about making a blog in PHP. Tool installation is possible from composer only.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

- PHP 7.4
- Xdebug 
- Git
- Compose
- pdo_mysql extension
- mysqli extension
- a database like MySQL or MariaDB

If you use a docker container, you can clone and build my container : https://github.com/Toka69/PHP-Template

### Installing

A step by step series of examples that tell you how to get a development env running

1) Clone the project in your workspace of your PHP environment.
2) Install the necessary libraries via composer
   ```
   php composer.phar install
   ```
3) Import the database located in the SQL_demo directory in your DBMS.
4) Copy the .env file to .env.local and change the settings according to your needs. The parameters present in .env.local overwrite those found in .env

```

APP_ENV=dev                             #dev = developpment mode, anything else for production.

DATABASE_HOST=localhost                 #Your database settings
DATABASE_PORT=3306
DATABASE_NAME=example
DATABASE_USER=root
DATABASE_PASSWORD=password

MAIL_SMTP=smtp.example.com              #Your SMTP to send mail
MAIL_PORT=25
MAIL_ENCRYPTION=ssl                     #or tls
MAIL_USER=user
MAIL_PASSWORD=password
MAIL_NOTIFICATION=admin@example.org     #the admin mail address that will be used to receive notifications

```
5) Start the PHP server.
6) Enjoy.

### Accounts existing in sql file 

- Administrator : john.boss@example.com 
- User 1 : eddie.ruiz@example.com
- User 2 : billie.miller@example.com

All accounts have the same password: Administrateur8!
