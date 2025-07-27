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

### Arquivo: `docker-compose.yml`

```yaml
services:
  # PHP Service
  laravel_php:
    build:
      context: ./images/php # Caminho para o Dockerfile do PHP
    container_name: laravel_php
    volumes:
      - ./volume_app:/var/www/html # Monta a pasta da aplicação Laravel
    networks:
      - laravel_network
    depends_on:
      - laravel_mysql # Garante que o MySQL esteja pronto antes do PHP iniciar
      - laravel_redis # Garante que o Redis esteja pronto antes do PHP iniciar

  # Nginx Service
  laravel_nginx:
    image: nginx:stable-alpine3.20 # Imagem oficial do Nginx
    container_name: laravel_nginx
    volumes:
      - ./images/nginx/default.conf:/etc/nginx/conf.d/default.conf # Configuração customizada do Nginx
      - ./volume_app:/var/www/html # Monta a pasta da aplicação Laravel
    ports:
      - "80:80" # Mapeia a porta 80 do host para a porta 80 do container
    networks:
      - laravel_network
    depends_on:
      - laravel_php # Garante que o PHP esteja pronto antes do Nginx iniciar

  # MySQL Service
  laravel_mysql:
    image: mysql:8.4.3 # Imagem oficial do MySQL na versão 8.4.3
    container_name: laravel_mysql
    ports:
      - "3306:3306" # Mapeia a porta 3306 do host para a porta 3306 do container
    environment:
      MYSQL_ROOT_PASSWORD: root # Senha root para o MySQL (ambiente de desenvolvimento)
    networks:
      - laravel_network
    volumes:
      - ./volume_data:/var/lib/mysql # Persistência dos dados do banco de dados

  # Redis Service
  laravel_redis:
    image: redis:latest # Imagem oficial mais recente do Redis
    container_name: laravel_redis
    ports:
      - "6379:6379" # Mapeia a porta 6379 do host para a porta 6379 do container
    networks:
      - laravel_network

networks:
  laravel_network:
    driver: bridge
    name: laravel_network # Nome da rede Docker para comunicação entre os containers



    # Imagem base: PHP 8.3.14-fpm
FROM php:8.3.14-fpm

# Instalação de dependências do sistema e ferramentas essenciais
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libssl-dev \
    libsqlite3-dev \
    libonig-dev \
    build-essential \
    curl \
    libtool \
    pkg-config \
    procps \
    libexif-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalação do Composer - gerenciador de dependências do PHP
RUN curl -sS [https://getcomposer.org/installer](https://getcomposer.org/installer) | php -- --install-dir=/usr/local/bin --filename=composer

# Configuração e instalação de extensões PHP comuns em aplicações Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip intl mbstring fileinfo exif

# Instalação e habilitação da extensão Redis para PHP
RUN pecl install redis \
    && docker-php-ext-enable redis

# Instalação do Node.js (versão 20.x) para gerenciamento de assets front-end (se aplicável)
RUN curl -fsSL [https://deb.nodesource.com/setup_20.x](https://deb.nodesource.com/setup_20.x) | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Limpeza de arquivos de cache e pacotes desnecessários para otimização da imagem
RUN apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
```

server {
listen 80; # Nginx escuta na porta 80 do container
server_name localhost; # Nome do servidor (acessível via localhost no host)

    root /var/www/html/public; # Define a raiz do documento para a pasta 'public' do Laravel

    index index.php index.html; # Ordem de arquivos de índice

    # Configuração de logs para acesso e erros
    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;

    location / {
        # Tenta servir o arquivo diretamente. Se não encontrar, passa a requisição para o index.php (Laravel)
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params; # Inclui parâmetros FastCGI padrão
        fastcgi_pass laravel_php:9000; # Encaminha requisições PHP para o container PHP-FPM na porta 9000
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; # Define o caminho completo do script
    }

    location ~ /\.ht {
        deny all; # Nega acesso a arquivos .ht (ocultos do Apache) por segurança
    }

}

Sim, vou mandar tudo em um único arquivo, como se fosse um README.md completo para o seu repositório. Ele incluirá a descrição do projeto, o link da produção, e os códigos docker-compose.yml, Dockerfile e default.conf do Nginx, além das instruções de uso.

Aqui está o arquivo:

Markdown

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

### Arquivo: `docker-compose.yml`

```yaml
services:
  # PHP Service
  laravel_php:
    build:
      context: ./images/php # Caminho para o Dockerfile do PHP
    container_name: laravel_php
    volumes:
      - ./volume_app:/var/www/html # Monta a pasta da aplicação Laravel
    networks:
      - laravel_network
    depends_on:
      - laravel_mysql # Garante que o MySQL esteja pronto antes do PHP iniciar
      - laravel_redis # Garante que o Redis esteja pronto antes do PHP iniciar

  # Nginx Service
  laravel_nginx:
    image: nginx:stable-alpine3.20 # Imagem oficial do Nginx
    container_name: laravel_nginx
    volumes:
      - ./images/nginx/default.conf:/etc/nginx/conf.d/default.conf # Configuração customizada do Nginx
      - ./volume_app:/var/www/html # Monta a pasta da aplicação Laravel
    ports:
      - "80:80" # Mapeia a porta 80 do host para a porta 80 do container
    networks:
      - laravel_network
    depends_on:
      - laravel_php # Garante que o PHP esteja pronto antes do Nginx iniciar

  # MySQL Service
  laravel_mysql:
    image: mysql:8.4.3 # Imagem oficial do MySQL na versão 8.4.3
    container_name: laravel_mysql
    ports:
      - "3306:3306" # Mapeia a porta 3306 do host para a porta 3306 do container
    environment:
      MYSQL_ROOT_PASSWORD: root # Senha root para o MySQL (ambiente de desenvolvimento)
    networks:
      - laravel_network
    volumes:
      - ./volume_data:/var/lib/mysql # Persistência dos dados do banco de dados

  # Redis Service
  laravel_redis:
    image: redis:latest # Imagem oficial mais recente do Redis
    container_name: laravel_redis
    ports:
      - "6379:6379" # Mapeia a porta 6379 do host para a porta 6379 do container
    networks:
      - laravel_network

networks:
  laravel_network:
    driver: bridge
    name: laravel_network # Nome da rede Docker para comunicação entre os containers
Arquivo: ./images/php/Dockerfile
Dockerfile

# Imagem base: PHP 8.3.14-fpm
FROM php:8.3.14-fpm

# Instalação de dependências do sistema e ferramentas essenciais
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libssl-dev \
    libsqlite3-dev \
    libonig-dev \
    build-essential \
    curl \
    libtool \
    pkg-config \
    procps \
    libexif-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalação do Composer - gerenciador de dependências do PHP
RUN curl -sS [https://getcomposer.org/installer](https://getcomposer.org/installer) | php -- --install-dir=/usr/local/bin --filename=composer

# Configuração e instalação de extensões PHP comuns em aplicações Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip intl mbstring fileinfo exif

# Instalação e habilitação da extensão Redis para PHP
RUN pecl install redis \
    && docker-php-ext-enable redis

# Instalação do Node.js (versão 20.x) para gerenciamento de assets front-end (se aplicável)
RUN curl -fsSL [https://deb.nodesource.com/setup_20.x](https://deb.nodesource.com/setup_20.x) | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Limpeza de arquivos de cache e pacotes desnecessários para otimização da imagem
RUN apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
Arquivo: ./images/nginx/default.conf
Nginx

server {
    listen 80; # Nginx escuta na porta 80 do container
    server_name localhost; # Nome do servidor (acessível via localhost no host)

    root /var/www/html/public; # Define a raiz do documento para a pasta 'public' do Laravel

    index index.php index.html; # Ordem de arquivos de índice

    # Configuração de logs para acesso e erros
    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;

    location / {
        # Tenta servir o arquivo diretamente. Se não encontrar, passa a requisição para o index.php (Laravel)
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params; # Inclui parâmetros FastCGI padrão
        fastcgi_pass laravel_php:9000; # Encaminha requisições PHP para o container PHP-FPM na porta 9000
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; # Define o caminho completo do script
    }

    location ~ /\.ht {
        deny all; # Nega acesso a arquivos .ht (ocultos do Apache) por segurança
    }
}
Instruções de Uso (Ambiente Local)
Siga estes passos para configurar e executar o ambiente de desenvolvimento local:

Pré-requisitos:

Faça o download ou clone este repositório para o seu ambiente de desenvolvimento (Windows WSL / Linux / MacOS).

Certifique-se de que o Docker esteja instalado e em execução no seu sistema.

Iniciar os Containers:

Navegue até a pasta raiz do repositório no seu terminal.

Execute o seguinte comando para construir (se necessário) e iniciar todos os containers em segundo plano:

Bash

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
