#!/bin/bash

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${YELLOW}Building MarketFlow containers...${NC}"
docker-compose build

echo -e "${YELLOW}Starting containers...${NC}"
docker-compose up -d

echo -e "${YELLOW}Waiting for containers to be ready...${NC}"
sleep 10

echo -e "${YELLOW}Installing Composer dependencies...${NC}"
docker-compose exec -T app composer install --no-interaction

echo -e "${YELLOW}Initializing environment...${NC}"
docker-compose exec -T app cp .env.example .env
docker-compose exec -T app php artisan key:generate

echo -e "${YELLOW}Running migrations and seeding...${NC}"
docker-compose exec -T app php artisan migrate:fresh --seed --force

echo -e "${YELLOW}Setting permissions...${NC}"
docker-compose exec -T app chmod -R 777 storage bootstrap/cache

echo -e "${GREEN}Setup complete!${NC}"
echo -e "${GREEN}Web: http://localhost${NC}"
echo -e "${GREEN}Admin: admin@marketflow.com / password${NC}"