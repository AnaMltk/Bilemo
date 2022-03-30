# Bilemo


## About the project

The goal of this project is to create an API with the following fonctionnalities : 

- consult BileMo product list ;
- consult product details ;
- consult client user list ;
- consult client user details ;
- add a new user for the client ;
- delete a user.
 

## Prerequisites

 -  PHP 7 or higher
 -  Symfony 5
 -  Mysql
 -  Composer

## Installation

### Clone the repo

```
$ git clone https://github.com/AnaMltk/Bilemo.git yourFolderName
$ cd yourFolderName
```

### Edit .env file OR create .env.local to avoid commiting sensible information 
``` 
DATABASE_URL="mysql://db_user:db_password:@127.0.0.1:3306/db_name?serverVersion=5.7"
```
For **database** connection, assign the values to **db_name**, **db_user** and **db_password**.

### Create database
run
```
$ php bin/console doctrine:database:create
```
### Composer
run
```
$ composer update
```
### Generate the SSL keys: 
run
```
php bin/console lexik:jwt:generate-keypair

```
### Run latest migration
run
```
$ php bin/console doctrine:migrations:migrate

```
### Upload data fixtures
run
```
$ php bin/console doctrine:fixtures:load

```

### Access documentation 
```
/api/doc

```


