# OurMarket.com(Web Development-1)

This application is a web-based ads platform that utilizes the following technologies:
- NGINX webserver
- PHP 8.1 
- MariaDB (GPL MySQL fork)
- PHPMyAdmin

## Features
- The homepage displays available ads and allows both logged in and non-logged in users to access them, sorted by recent dates. 
- The "My Ads" page, accessible only to logged in users, allows for CRUD operations on ad posts, including editing, marking as sold, and deleting. 
- There is a Search bar also where products can be searched in the entire database.
- The application also includes four local APIs for editing, creating, deleting and searching products, and a shopping cart feature for purchasing them. 
- The application use the Argon2 for password hashing and verifying.
- The application is  included to create the MYSQL database.

## Running the Application
To run the application, use the command:
```bash
docker-compose up
```
after docker is composed  open http://localhost/home/myAds 

## Test Users
Two test users have been provided with the following credentials:
#### - First User- Test
email:
```bash
test@inholland.nl
```
password:
```bash
Secret123
```
---------------------------------------
#### - Second User- Bijay
- email:
```bash
bijay@inholland.nl
```
password:
```bash
Developer123
```
