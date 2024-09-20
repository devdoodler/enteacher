# EnTeacher

## How to install:
1. Build docker: `docker compose build`
2. Start application by `docker compose up`
## Terminal
1. You can get to terminal in docker by: `docker-compose exec -u 1000 fpm bash`
2. Run tests (in bash): `php bin/phpunit`
## HTTP Request

#### POST {{url}}/word
body:
{
  "name": "chips",
  "dialect": "general",
  "explanation": "a long thin piece of potato fried in oil or fat",
  "pronunciation": "/tʃɪp/"
}

#### GET {{url}}/word/{id}
#### PUT {{url}}/word/{id}
body:
{
"name": "chips",
"dialect": "general",
"explanation": "a long thin piece of potato fried in oil or fat",
"pronunciation": "/tʃɪp/"
}
