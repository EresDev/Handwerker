# Symfony Skeleton Advanced With JWT Security

[![Build Status](https://travis-ci.org/EresDev/SymfonySkeletonAdvanced.svg?branch=master)](https://travis-ci.org/EresDev/SymfonySkeletonAdvanced)

This is a ready to use Skeleton Application based on Symfony. It contains code and tests to setup User authentication with lexik JWT bundle, and Alice Fixture Bundle.

It is based on Hexagonal Architecture. Not only it helps you to get started quickly, but it promotes loose-coupling and helps you learn the best programming practices. Just clone the repository and start working.

Services included: Repository, Validator, Translator, AliceBundle and Doctrine

## Prerequisites
- PHP 7.4+
- MySQL 

## How to deploy

- Clone the repository.
```
git clone https://github.com/EresDev/SymfonySkeletonAdvanced
```
- Install it.
```
composer install
```
- Create MySQL database if you have not already created.
```
php bin/console doctrine:database:create  --if-not-exists
```
It will give you errors if there is a problem in connecting to MySQL. Fix them accordingly. 
You can update the database details in .env file.

- Create database schema
```
php bin/console doctrine:schema:create 
```
- Generate SSH keys
```
mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:879329hr8uhgf7834rhgiuw834hr
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -passin pass:879329hr8uhgf7834rhgiuw834hr -pubout 
```
Here `879329hr8uhgf7834rhgiuw834hr` is the passphrase that you have to replace with one of your choice. If you are just performing a quick test, keep the value, it will help you get it working quickly but it must be taken care of before going to production.

- Update the JWT_PASSPHRASE in .env or .env.local

- Run the tests
```
composer test
```
Happy coding! 
