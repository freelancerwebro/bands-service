# 🎵 Bands Service
A RESTful service built with **PHP**, **Symfony**, and **MySQL** for importing and managing bands using an Excel file.

## 📖 **Project Description**
This project provides an **import system** for an Excel/CSV file, allowing bands to be stored in a database and accessed via an API.

### **📝 Context**
- **As a client**, I want my Excel file to be imported into a database
- **In order to** consult, modify, or delete the information

## 🔧 Tech Stack
- Symfony 7.2
- PHP 8.4
- MySQL 8
- REST API
- Docker
- PHPUnit

## 🔧 Requirements
- [git](https://github.com/git-guides/install-git)
- [docker-compose](https://docs.docker.com/compose/install/)
- [docker](https://www.docker.com/get-started/)
- [PHP](https://www.php.net/manual/en/install.php)

## 📦 Installation
🔹 Clone the git repository:
```
git clone git@github.com:freelancerwebro/bands-service.git
```

🔹 Run the following command to build the service:
```
./deploy.sh
```

## ✅ Running Tests:
```
composer test
```

## 📂 API Endpoints:
```
- POST `/import`: Import bands from an Excel/CSV file
- GET `/band`: List all bands
- GET `/band/{id}`: Retrieve a single band
- POST `/band`: Add a new band
- PUT `/band/{id}`: Update an existing band
- DELETE `/band/{id}`: Delete a band
```