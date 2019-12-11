# Symfony Skeleton Advanced With JWT Security

[![Build Status](https://travis-ci.org/EresDev/SymfonySkeletonAdvanced.svg?branch=master)](https://travis-ci.org/EresDev/SymfonySkeletonAdvanced)

This is a ready to use Skeleton Application based on Symfony. It contains code and tests to setup User authentication with lexik JWT bundle, and Alice Fixture Bundle.

The folder structure is based on Hexagonal Architecture. Not only it helps you to get started quickly, but it promotes loose-coupling and helps you learn the best programming practices. Just clone the repository and start working.

Services included: Repository, Validator, Translator and Doctrine

## Prerequisites
- PHP 7.4+
- MySQL 

## How to deploy

- Clone the repository.

`git clone https://github.com/EresDev/SymfonySkeletonAdvanced`

- Install it.

`composer install`

- Create MySQL database if you have not already created.

`php bin/console doctrine:database:create`

- Add the MySQL connection details to .env file

- Run the tests

`composer test`

Happy coding! 
