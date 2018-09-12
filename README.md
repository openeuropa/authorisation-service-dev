# Authorisation Service Development

Development service for Authorisation Service (Apache Syncope).


## Development setup

You can build the test site by running the following steps.

* Install all the composer dependencies:

```
$ composer install
```


## Using Docker Compose

You can build and test the service using Docker and Docker-compose with the provided configuration.

Requirements:

- [Docker](https://www.docker.com/get-docker)
- [Docker-compose](https://docs.docker.com/compose/)

Run:

```
$ docker-compose up -d
```

Then:

```
$ docker-compose exec web oe-authorisation-service:setup
```

To run the grumphp test:

```
$ docker-compose exec web ./vendor/bin/grumphp run
```
