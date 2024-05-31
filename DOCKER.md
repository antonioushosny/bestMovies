### 4. Using Docker

**File: `DOCKER.md`**

This file provides instructions for setting up and running the project using Docker.

# Docker Setup Instructions

## Prerequisites
- Docker
- Docker Compose

## Building the Docker Image
Build the Docker image for the application.

```bash
docker-compose build
```

# Running the Application
## Start the application using Docker Compose.
```bash
docker-compose up --build
```

# Stopping the Application
## Stop the running containers
```bash
 docker-compose down
```

# Running Tests in Docker
## Run tests within the Docker container.
```bash
docker-compose exec app php artisan test --coverage-html=coverage  
```