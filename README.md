# Example project
This is an example of Budget request form made for an old recruitment process
where I have been [ghosted](https://en.wikipedia.org/wiki/Ghosting_(employer)) due to COVID-19 pandemic.

## Installation
* Go to the root folder and use `docker-compose exec php composer install -vvv -d /usr/local/apache2/htdocs`
* Create a .env file using `cp .env.example .env`
* Edit data of .env file using the correct data for your environment
* Follow steps of __Database migrations and seeding__
* If you find permissions problems, you can issue this command: `docker-compose exec php chmod -R 777 /usr/local/apache2/htdocs/storage`
* Set encryption key with `docker-compose exec php php /usr/local/apache2/htdocs/artisan key:generate`
* `npm install && npm run dev`

## Docker environment
To execute this application, you can use Docker containers provided with the *docker-compose.yml* file.
You can bring up docker containers with command `docker-compose up -d`
API will be listening on http://localhost:8080/api

## Database migrations and seeding
You can create tables and fill up with dummy data before executing tests using the following commands:
* `php artisan migrate`
* `php artisan db:seed`

If you use docker environment, you can use:
* `docker-compose exec php php /usr/local/apache2/htdocs/artisan migrate`
* `docker-compose exec php php /usr/local/apache2/htdocs/artisan db:seed`

## Frontend landing
Budget request form is placed on root of folder, so you can access it directly on http://localhost:8080 using docker

## Tests
You can run tests with the following command:

* `docker-compose exec php php /usr/local/apache2/htdocs/vendor/bin/phpunit /usr/local/apache2/htdocs/tests --testdox` 

## Documentation

Using docker containers, you can check the Swagger documentation directly on http://localhost:8080/api/documentation, 
where you can test each endpoint.

If you need the json of the api, you can get it on http://localhost:8080/docs 
