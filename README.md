# User Management Application (Laminas + MySQL)

## Description

Simple Application that manage the users (Add, update, delete with listing)

## Update database connection details
#### Make a copy of `local.php.dist` as `local.php` and add database details like below

```
    'db' => [
        'driver' => 'PDO',
        'dsn' => 'mysql:host=DB_HOST_NAME;dbname=DB_NAME',
        'username' => 'DB_USERNAME',
        'password' => 'DB_PASSWORD'
    ]
```

#### NOTE:- You can use SQL file which is located at root directory of this application. Which name like `laminas_demo.sql`


## Install depandancies on local

```bash
$ composer update
```

## Install depandancies on server

```bash
$ composer install
```

#### Take a note that never run `composer update` command on server (staging/production)

## Run the application

```bash
$ composer serve
```

## Localhost URL

```
$ http://localhost:8080
```