#!/bin/bash

echo "=== Laravel App Deployment ==="

# Load environment variables
if [ -f .env.docker ]; then
    echo "Loading environment variables..."
    cp .env.docker .env
fi

# Build Docker image
echo "Building Docker image..."
docker build -t your-username/laravel-app:latest .

# Run container
echo "Starting container..."
docker run -d \
    --name laravel-production \
    -p 80:80 \
    --env-file .env \
    your-username/laravel-app:latest

echo "Deployment completed!"
echo "Application running on: http://localhost"
echo ""
echo "Useful commands:"
echo "docker logs laravel-production -f  # View logs"
echo "docker stop laravel-production     # Stop container"
echo "docker start laravel-production    # Start container"
echo "docker exec -it laravel-production bash  # Enter container"