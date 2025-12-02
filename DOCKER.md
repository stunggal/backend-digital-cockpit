# Docker deployment & local stack

This repository includes a simple Docker setup to run the application (PHP-FPM + Nginx + MySQL).

Quick steps
- Build images and start containers:
  - `docker compose up -d --build`
- Generate an app key (inside the app container):
  - `docker compose exec app php artisan key:generate --ansi`
- Run migrations:
  - `docker compose exec app php artisan migrate --force`

Notes
- The `app` service builds from the `Dockerfile` and exposes PHP-FPM on port `9000`.
- The `web` service uses Nginx and maps host port `80` to container port `80`.
- MySQL data is persisted in the `dbdata` Docker volume.

Development
- The `docker-compose.yml` mounts the project directory into the `app` container for convenience. If you change dependencies, run `composer install` inside the container or rebuild the image.

Environment
- Use `.env.docker` as a starting point for Docker deployment; copy to `.env` and set `APP_KEY` and other secrets before running in production.

Security & production
- For production, consider using a managed database, secure secrets (do not commit `.env`), TLS termination, and an optimized PHP image and caching layer. Also review file permissions and disable Xdebug.
