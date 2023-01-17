# Web-based Ads Platform

This application is a web-based ads platform that utilizes the following technologies:
- NGINX webserver
- PHP 8.1 with Argon 2 password hasher 
- MariaDB (GPL MySQL fork)
- PHPMyAdmin

## Features
- The homepage displays available ads and allows both logged in and non-logged in users to access them, sorted by recent dates. 
- The "My Ads" page, accessible only to logged in users, allows for CRUD operations on ad posts, including editing, marking as sold, and deleting. 
- The application also includes four local APIs for editing, creating, deleting and searching products, and a shopping cart feature for purchasing them. 

## Running the Application
To run the application, use the command `Docker Compose up`.

## Test Users
Two test users have been provided with the following credentials:
- test@inholland.nl / Secret123
- bijay@inholland.nl / Developer123
