echo 'Prepare config files...'
cp phpunit.xml.dist phpunit.xml
cp .env.example .env

echo 'Building containers...'
docker-compose up -d --build

echo 'Installing composer...'
docker exec -it bands-service-php composer install --prefer-dist --no-progress --no-interaction

echo 'Creating database...'
docker exec -it bands-service-php php bin/console doctrine:database:create --if-not-exists --no-interaction

echo 'Running migrations...'
docker exec -it bands-service-php php bin/console doctrine:migrations:migrate --no-interaction
docker exec -it bands-service-php php bin/console cache:clear --no-interaction

echo 'Generate swagger documentation...'
docker exec -it bands-service-php php bin/console api:openapi:export --format=json > swagger.json
