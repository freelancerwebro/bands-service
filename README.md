# Bands Service
Implementation of a Bands Service with PHP 8.3, Symfony 7 and MySQL 8.
The purpose of the service is to import bands using an Excel file and make them available with an API.

## Requirements
- git
- docker-compose

## Installation
Clone the git repository:
```
git clone git@github.com:freelancerwebro/bands-service.git
```

In order to build the service, run the command:
```
./deploy.sh
```

Run tests:
```
composer test
```

API usage:
```
- POST `/import`: Import excel file
- GET `/band`: List bands
- GET `/band/{id}`: Get one band
- POST `/band`: Create new band
- PUT `/band/{id}`: Update existing band
- DELETE `/band/{id}`: Delete existing band
```