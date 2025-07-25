# LARAVEL

Infraestrutura Docker-compose para criação de ambiente local de desenvolvimento em ecossistema Laravel 11.

- NginX
- PHP 8.3
- MySQL 8.4.3
- Redis

# Instruções de uso

- Fazer o download do repositório para Windows WSL / Linux / MacOS (garantir que o Docker está disponível no sistema)
- Dentro da pasta do repositório executar o comando
  > docker-compose up -d
- Vão ser criados os containers: laravel_nginx, laravel_php, laravel_mysql, laravel_redis
- Utilizar o VSCode para acessar remotamente ao container de php e usar como pasta de trabalho /var/www/html
