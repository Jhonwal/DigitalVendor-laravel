#!/bin/bash

# Colors for terminal output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}Starting Laravel Digital Marketplace on port 8080...${NC}"

# Kill any existing PHP server processes
pkill -f "php -S" > /dev/null 2>&1 || true

# Clear previous logs
echo "" > server.log

# Information about available routes
echo -e "${YELLOW}Available routes:${NC}"
echo -e "${GREEN}Home:${NC} http://localhost:8080/"
echo -e "${GREEN}Products:${NC} http://localhost:8080/products"
echo -e "${GREEN}Login:${NC} http://localhost:8080/login"
echo -e "${GREEN}Register:${NC} http://localhost:8080/register"
echo -e "${GREEN}Dashboard:${NC} http://localhost:8080/dashboard (requires login)"
echo ""
echo -e "${YELLOW}Test accounts:${NC}"
echo -e "${GREEN}Admin:${NC} admin@example.com / password"
echo -e "${GREEN}Seller:${NC} seller@example.com / password"
echo -e "${GREEN}Buyer:${NC} buyer@example.com / password"
echo ""

# Start PHP server, don't use exec to allow the script to terminate
php -S 0.0.0.0:8080 -t public