# Projeto Despesas de Deputados - API Câmara

Este repositório contém uma aplicação **Laravel 11** que consome a API de Dados Abertos da Câmara dos Deputados para listar deputados e suas despesas. O projeto foi desenvolvido com um ambiente Docker Compose para facilitar o desenvolvimento local e já está **em produção**.

---

## Projeto em Produção

O projeto pode ser acessado publicamente através do seguinte link:

**Link de Acesso:** [https://apideputados.devmorais.com.br/public/](https://apideputados.devmorais.com.br/public/)

---

## Infraestrutura Docker Compose

A infraestrutura para o ambiente de desenvolvimento local é construída utilizando Docker Compose, garantindo um ambiente consistente e isolado. Os seguintes serviços são configurados:

- **Nginx:** Servidor web para a aplicação Laravel.
- **PHP 8.3:** Ambiente de execução otimizado para Laravel 11.
- **MySQL 8.4.3:** Banco de dados relacional para persistência das despesas dos deputados.
- **Redis:** Utilizado para gerenciar filas assíncronas (Laravel Jobs), otimizando o processamento de dados da API.

---

## Pré-requisitos:

Faça o download ou clone este repositório para o seu ambiente de desenvolvimento (Windows WSL / Linux / MacOS).

Certifique-se de que o Docker esteja instalado e em execução no seu sistema.

Iniciar os Containers:

Navegue até a pasta raiz do repositório no seu terminal.

Execute o seguinte comando 

docker-compose up -d
Verificação:

Após a execução do comando, os seguintes containers serão criados e iniciados: laravel_nginx, laravel_php, laravel_mysql, laravel_redis.

Você pode verificar o status dos containers com docker ps.

Acesso ao Código (VS Code):

Para uma melhor experiência de desenvolvimento, utilize o VS Code com a extensão "Remote - Containers".

Acesse remotamente o container laravel_php. A pasta de trabalho para o seu projeto Laravel dentro do container será /var/www/html.

Acesso à Aplicação:

Uma vez que os containers estejam rodando, a aplicação Laravel estará acessível no seu navegador via: http://localhost/
```
