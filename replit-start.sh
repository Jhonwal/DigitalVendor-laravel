#!/bin/bash

# Simple wrapper to start the PHP server for Laravel in Replit
# This script ensures clean startup and proper handling of PHP server

echo "Starting Laravel Digital Marketplace on port 8080..."

# Kill any existing PHP servers
pkill -f "php -S" > /dev/null 2>&1 || true

# Clear any previous logs
echo "" > server.log

# Start PHP server using our custom router
exec php -S 0.0.0.0:8080 run-server.php