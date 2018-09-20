# code-challenge

## Requirements
* mysql 5.7
* php 7

## Installing

Copy the project
```bash
$ git clone git@github.com:greentopsecret/code-challenge.git
```

Go to the project directory 
```bash
$ cd code-challenge/
```

Install dependencies
```bash
$ composer install
```

Adjust DB credentials 
```bash
$ vim .env
$ vim config/packages/test/doctrine.yaml

```

Create DB and load seed data
```bash
$ bin/console doctrine:database:create --env=prod
$ bin/console doctrine:database:create --env=test
$ bin/console doctrine:schema:update --force --env=prod
$ bin/console doctrine:schema:update --force --env=test
$ bin/console doctrine:migrations:migrate -n --env=prod
$ bin/console doctrine:migrations:migrate -n --env=test
```

Run application using a local web server
```bash
php -S 127.0.0.1:8000 -t public
```

## Run tests
```bash
$ bin/phpunit
```

## TODO:
- [ ] Dockerize the project 
- [ ] Use [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) for generating api
- [ ] Implement GET /api/orders/ method
    -  [ ] add properties Order::$createdAt, Order::$updatedAt.
    -  [ ] filter elements by initial creation (not older than 30 days)
    -  [ ] filter elements by service
    -  [ ] filter elements by region
- [ ] Implement GET /api/cities/ method <sup>*</sup>

<sup>*</sup> - Instead of returning list of available cities and zip codes (that can be quite long), extra query could be used.


## Possible enhancements
* [ ] **Order::$executionDate:** 
Possible values for Order::$executionDate property could be described as relation to new entity.
* [ ] **Hide specific Entities' fields from exposing:** 
Exclusion policies could be used for that purpose.
* [ ] Do something with **deprecation notice** in test. Currently cannot be fixed because of [that](https://github.com/symfony/symfony/issues/28119).
 