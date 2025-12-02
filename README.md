# Backend Digital Cockpit - API

A minimal backend for the Digital Cockpit project — API-focused Laravel application.

**Subtitle:** A lightweight Laravel API for patient monitoring and scheduling

**Slogan:** "Make clinical data actionable — one API at a time."

**Last commit:** N/A (no local git info available). To update this locally run:

```bash
git -C "$(pwd)" log -1 --pretty=format:"%h - %s (%ci)"
```

## Languages

-   PHP
-   JavaScript
-   CSS
-   Shell (bash)
-   Dockerfile
-   YAML
-   JSON

**Number of distinct languages:** 7

## Table of Contents

-   Overview
-   Getting Started
    -   Prerequisites
    -   Installation
-   Usage
    -   Environment variables
    -   Running migrations & seeders
    -   Starting the application
-   API Endpoints (summary)
-   Testing
-   Contributing
-   Troubleshooting
-   License & Contact

## Overview

This repository contains the backend API for "Digital Cockpit" — a Laravel-based
service that provides patient scheduling, basic vitals ingestion (HR, SpO2,
blood pressure) and integration points for LLM-based recommendations and
time-series storage (InfluxDB).

The codebase focuses on:

-   Eloquent models for `Pasien`, `Dokter`, `Jadwal`, and simple vitals models
    (`Heartrate`, `Spo2`, `Bloodpressure`).
-   API controllers under `app/Http/Controllers/Api` for authenticated endpoints.
-   Database factories and migrations to seed sample/test data.

## Getting Started

### Prerequisites

-   PHP 8.x (matching this project's composer requirements)
-   Composer
-   A database supported by Laravel (MySQL, MariaDB, SQLite for local testing)
-   Node.js + npm (optional for frontend assets)
-   Docker (optional for containerized runs)

### Installation

1. Clone the repository:

```bash
git clone <repo-url> && cd api-backend-digital-cockpit
```

2. Install PHP dependencies:

```bash
composer install
```

3. Copy the environment file and update the values:

```bash
cp .env.example .env
# Update DB credentials, APP_KEY, and any Influx/LLM webhook settings in .env
php artisan key:generate
```

4. (Optional) Install frontend dependencies for assets:

```bash
npm install
npm run build
```

## Usage

### Environment variables

-   `APP_URL`, `DB_*` — standard Laravel settings
-   `INFLUXDB_URL`, `INFLUXDB_TOKEN`, `INFLUXDB_ORG`, `INFLUXDB_BUCKET` — InfluxDB write support
-   `LLM_WEBHOOK_URL` — external webhook used by LLM recommendation endpoints

### Running migrations & seeders

```bash
php artisan migrate --seed
```

### Starting the application

```bash
# Built-in PHP server for quick local testing
php artisan serve --host=127.0.0.1 --port=8000

# Or use Docker (if Dockerfile and docker-compose.yml are configured)
docker-compose up --build
```

## API Endpoints (summary)

-   `POST /auth/login` — authenticate and receive a Sanctum token
-   `POST /auth/logout` — revoke current token (auth required)
-   `POST /get-loged-user-data` — fetch current user profile (auth required)
-   `POST /get-heart-rate` — latest heart rate for a user (auth required)
-   `POST /get-blood-pressure` — latest BP reading (auth required)
-   `POST /get-spo2` — latest SpO2 reading (auth required)
-   `POST /get-jadwal-dokter` — today's schedule for a doctor (auth required)
-   `POST /get-pasien` — patient details (auth required)
-   `POST /get-jadwal-pasien-past` — past appointments (auth required)
-   `POST /get-jadwal` — appointment listing (auth required)
-   `POST /get-pasien-list` — list of patients (auth required)
-   `POST /llm-recom-food` — proxy to external LLM/recommendation webhook (auth required)
-   `POST /influxdb-write` — write sensor/time-series data to InfluxDB (public by default — consider protecting)

Refer to `routes/api.php` for exact route URIs and controller mappings.

## Testing

Run automated tests using Pest or PHPUnit if present in the repository.

```bash
./vendor/bin/pest
# or
./vendor/bin/phpunit
```

If you use a fresh database for testing you can seed sample data with:

```bash
php artisan migrate:fresh --seed
```

## Contributing

-   Fork the repo and create a feature branch.
-   Write tests for new features where applicable.
-   Keep changes focused and add documentation for breaking changes.

## Troubleshooting

-   If you see Influx-related errors, verify `INFLUXDB_*` env vars and network access.
-   If the LLM webhook calls fail, set `LLM_WEBHOOK_URL` or disable the LLM endpoints
    in `routes/api.php` during local development.

## License & Contact

This project does not include an explicit license file. Add a `LICENSE` if
you plan to open-source the repository. For questions contact the repo owner.

---

If you'd like, I can also:

-   Insert the actual latest git commit into the `Last commit` field if you
    allow me to run git locally, or you can run the command above and paste the result.
-   Generate a concise changelog of edits I made during previous sessions.
