
# Docker-Based Setup Instructions

## Prerequisites

- Install Docker: [Docker installation guide](https://docs.docker.com/get-docker/)
- Install Docker Compose: [Docker Compose installation guide](https://docs.docker.com/compose/install/)

## Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/scify/Crowdsourcing-Platform.git
    cd Crowdsourcing-Platform
    ```

2. Build and run the containers:
    ```bash
    docker compose up --build
    ```

3. Access the application:
    - Application: [http://localhost:89](http://localhost:89)
    - PHPMyAdmin: [http://localhost:8081](http://localhost:8081)

4. Run Laravel setup commands inside the container:
    ```bash
    docker exec -it crowdsourcing_platform_server bash
    php artisan migrate
    php artisan db:seed
    php artisan key:generate
    php artisan storage:link
    ```

5. Optional: Compile front-end assets:
    ```bash
    npm install
    npm run dev
    ```

Refer to the main README for additional details.
