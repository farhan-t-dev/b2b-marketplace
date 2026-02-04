#!/bin/bash

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}🚀 Building Marketplace containers...${NC}"
docker-compose build

echo -e "${YELLOW}🚀 Starting containers...${NC}"
docker-compose up -d

echo -e "${YELLOW}⏳ Waiting for containers to be ready...${NC}"
sleep 5

echo -e "${YELLOW}📦 Installing Composer dependencies...${NC}"
docker-compose exec -T app composer install --no-interaction

echo -e "${YELLOW}🔑 Generating app key...${NC}"
docker-compose exec -T app php artisan key:generate

echo -e "${YELLOW}🗄️  Running migrations...${NC}"
docker-compose exec -T app php artisan migrate:fresh

echo -e "${YELLOW}🌱 Seeding database...${NC}"
docker-compose exec -T app php artisan db:seed

echo -e "${GREEN}✅ Setup complete!${NC}"
echo -e "${GREEN}🌐 App running at: http://localhost${NC}"
echo -e "${GREEN}🗄️  Database: localhost:3306${NC}"
echo -e "${GREEN}🔍 Meilisearch: http://localhost:7700${NC}"
