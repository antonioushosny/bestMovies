# Best Movies App

## Overview
it's a small project for store movies in db and include apis for show , store , update and delete movie also api for add movie to favorite with call api from tmdb to get more for the movie 

## Table of Contents
1. [Project Structure](#project-structure)
2. [Setup Process](#setup-process)
3. [Prerequisites](#prerequisites)
4. [Using Docker](#using-docker)
 

#project-structure
```plaintext
.
├── app/                # Application logic
├── config/             # Configuration files
├── database/           # Database migrations and seeders
├── public/             # Publicly accessible files
├── resources/          # Views and assets
├── routes/             # Route definitions
├── storage/            # Storage for logs, sessions, and other files
├── tests/              # Automated tests
├── Dockerfile          # Docker configuration
├── docker-compose.yml  # Docker Compose configuration
├── .env.example        # Example environment configuration
└── README.md           # Project documentation

```

## Setup Process

### Clone the Repository
    git clone https://github.com/antonioushosny/bestMovies.git
    cd bestMovies

### Environment Variables
    cp .env.example .env

### Install Dependencies
    composer install

### Generate Application Key
    php artisan key:generate

### Run Migrations and Seeders
    php artisan migrate
    php artisan migrate --seed

### Start the Application
    php artisan serve
### Running Tests
    php artisan test
    php artisan test --coverage-html=coverage   

# Note: if you use Docker you can run php cmmand as "docker-compose exec app php" instead of "php"
## Prerequisites
    - PHP >= 8.0
    - Composer
    - Docker (optional, for containerized setup)


