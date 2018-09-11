# Authorisation Service Development

Development service for Authorisation Service (Apache Syncope).


## Development setup

You can build the test site by running the following steps.

* Install all the composer dependencies:

```
composer install
```

## Using Docker Compose

You can build and test the service using Docker and Docker-compose with the provided configuration.

Requirements:

- [Docker](https://www.docker.com/get-docker)
- [Docker-compose](https://docs.docker.com/compose/)

Run:

```
docker-compose up -d
```

Then:

```
docker-compose exec syncope ./vendor/bin/robo setup
```

To list all commands:

```
docker-compose exec syncope ./vendor/bin/robo
```

Full rebuild `syncope` service during development:

```
docker-compose build --force-rm --no-cache syncope
```