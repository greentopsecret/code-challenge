# Code challenge

## Requirements
* mysql 5.7
* php 7.2

## Installing

Copy the project
```bash
$ git clone https://github.com/greentopsecret/code-challenge.git
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

```

Create DB and load seed data
```bash
$ bin/console doctrine:database:create --env=dev
$ bin/console doctrine:database:create --env=test
$ bin/console doctrine:schema:update --force --env=dev
$ bin/console doctrine:schema:update --force --env=test
$ bin/console doctrine:migrations:migrate -n --env=dev
$ bin/console doctrine:migrations:migrate -n --env=test
```

## Run tests
```bash
$ bin/phpunit
```

Run application using a local web server
```bash
php -S 127.0.0.1:8000 -t public &
```

## Usage

### Get form
```bash
$ curl -X GET \http://127.0.0.1:8000/api/orders/new

HTTP/1.1 200 OK
Host: 127.0.0.1:8000
Date: Thu, 20 Sep 2018 08:00:09 +0200
Connection: close
X-Powered-By: PHP/7.2.9
Cache-Control: no-cache, private
Date: Thu, 20 Sep 2018 06:00:09 GMT
Content-Type: application/json
Allow: GET

{
    "form": {
        "vars": {
            "attr": [],
            "id": "order",

            ...

        }
    }
}

```

### Create new order
```bash
$ curl -i -X POST \
  http://127.0.0.1:8000/api/orders/ \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -d 'order%5Bdescription%5D=description&order%5BexecutionDate%5D=10&order%5Bcity%5D=10115&order%5Bservice%5D=108140&order%5Btitle%5D=title'
  

HTTP/1.1 201 Created
Host: 127.0.0.1:8000
Date: Thu, 20 Sep 2018 07:58:46 +0200
Connection: close
X-Powered-By: PHP/7.2.9
Cache-Control: no-cache, private
Date: Thu, 20 Sep 2018 05:58:46 GMT
Location: http://127.0.0.1:8000/api/orders/26   <--
Allow: POST
Content-Type: application/json
```

### Update existing order
```bash
curl -i -X PATCH \
  http://127.0.0.1:8000/api/orders/26 \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -d 'order%5Btitle%5D=new%20title&='
  
HTTP/1.1 200 OK
Host: 127.0.0.1:8000
Date: Thu, 20 Sep 2018 08:03:30 +0200
Connection: close
X-Powered-By: PHP/7.2.9
Cache-Control: no-cache, private
Date: Thu, 20 Sep 2018 06:03:30 GMT
Content-Type: application/json
Allow: PATCH, GET

{
    "data": {
        "id": 26,
        "title": "new title",
        "service": {
            "id": 108140,
            "name": "Kellersanierung"
        },
        "city": {
            "id": 1,
            "name": "Berlin",
            "zip": "10115"
        },
        "description": "description",
        "execution_date": 10
    }
}
```

### Receive existing order
```bash
curl -i -X GET \
  http://127.0.0.1:8000/api/orders/26 \
  -H 'Cache-Control: no-cache'
  
HTTP/1.1 200 OK
Host: 127.0.0.1:8000
Date: Thu, 20 Sep 2018 08:21:03 +0200
Connection: close
X-Powered-By: PHP/7.2.9
Cache-Control: no-cache, private
Date: Thu, 20 Sep 2018 06:21:03 GMT
Content-Type: application/json
Allow: PATCH, GET, POST

{
    "data": {
        "id": 26,
        "title": "new title",
        "service": {
            "id": 108140,
            "name": "Kellersanierung"
        },
        "city": {
            "id": 1,
            "name": "Berlin",
            "zip": "10115"
        },
        "description": "description",
        "execution_date": 10
    }
}
``` 


## TODO:
- [ ] Use [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) for generating api (~3 Hours)
- [ ] Implement GET /api/orders/ method (~1.5 Hours)
    -  [ ] add properties Order::$createdAt, Order::$updatedAt.
    -  [ ] filter elements by initial creation (not older than 30 days)
    -  [ ] filter elements by service
    -  [ ] filter elements by region
- [ ] Implement GET /api/cities/ method <sup>*</sup> (~0.5 Hours)

<sup>*</sup> - Instead of returning list of available cities and zip codes (that can be quite long), extra query could be used.


## Possible enhancements
* [ ] **dockerize** entire application 
* [ ] **Order::$executionDate:** 
Possible values for Order::$executionDate property could be described as relation to new entity.
* [ ] **Hide specific Entities' fields from exposing:** 
Exclusion policies could be used for that purpose. (~1-2 Hours)
* [ ] Do something with **deprecation notice** in test. Currently cannot be fixed because of [that](https://github.com/symfony/symfony/issues/28119).
 