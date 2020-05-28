# Vending-machine



The goal of this program is to model a vending machine.  The machine works like all vending machines: it takes money then gives you items. The vending machine accepts money in the form of 0.05, 0.10, 0.25 and 1.



### Some things to take in consideration.

I built it using CQRS, hexagonal architecture and DDD. I used symfony console as the only dependence. For the persistence method, I used files. The test are with PHPUnit.



### Installation

1. [Install Docker](https://www.docker.com/get-started)
2. Move to the project root folder
3. Run docker compose

```sh
docker-compose up 
```

1. Go into the container
2. Move to the app root folder 

```sh
cd /app 
```

1. Execute composer install

```sh
composer install
```

### Run test

```sh
composer run-script test
```

### Available commands

```sh
php apps/VendingMachine/bin/console list
```

### 

### Run insert coin

```sh
php apps/VendingMachine/bin/console insert-coin 0.25
```

### Run return insert coin

```sh
php apps/VendingMachine/bin/console return-coins
```

### Run buy product

```sh
php apps/VendingMachine/bin/console buy-product soda
```

### Run set service

```sh
php apps/VendingMachine/bin/console set-service products '[[\"juice\",10],[\"water\",9],[\"soda\",10]]'
```

or 

```sh
php apps/VendingMachine/bin/console set-service change '[[1,10],[0.25,10],[0.1,10],[0.05,10]]'
```









