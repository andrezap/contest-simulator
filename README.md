This project was created with 
- Symfony 5
- PHP 7.4
- Postresql
- Docker

To run please follow the instruction bellow:

## Installation

1. docker-compose up -d
2. docker-compose exec --user 1000:1000 php fish
3. composer install
4. php bin/console doctrine:migrations:migrate 

## Usage

You can access the project at localhost:80
