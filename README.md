# README for Currency Conversion Application

This README provides an overview and step-by-step guide for setting up and running the Currency Conversion Application, which allows users to convert currencies based on exchange rates from fixer.io. The application is containerized with Docker and includes a PostgreSQL database for storing conversion data. This README assumes you have Docker installed on your machine.

## Table of Contents
- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
    - [Setting Up the Environment](#setting-up-the-environment)
    - [Running the Application](#running-the-application)
- [Using the Application](#using-the-application)
- [Unit Testing](#unit-testing)
- [Project Structure](#project-structure)

## Prerequisites

Before you begin, make sure you have the following installed on your system:

- Docker: [Install Docker](https://docs.docker.com/get-docker/)

## Getting Started

### Setting Up the Environment

1. Clone the repository to your local machine:

    ```bash
    git clone <repository_url>
    cd <repository_directory>
    ```

### Running the Application

The application is set up to use Docker and Docker Compose for easy deployment.

1. Build the Docker containers by running the following command in the project directory:

    ```bash
    docker-compose up --build
    ```
   
2. For populating the database first start the easytest-php container and run the migrations
   ```bash
    docker exec -it easytest-php sh
    php artisan migrate
    ```

3. You can use the following commands if you want to stop or start the docker at later point:

    ```bash
    docker-compose up
    docker-compose down
    ```

4. Once the application is up and running, you can access it at [http://localhost:8000](http://localhost:8000).

## Using the Application

The Currency Conversion Application provides an endpoint for currency conversion. To use it, make a request on the specified endpoint URL. You should include the following payload parameters:

- `source_currency`: The currency you want to convert from (e.g., USD).
- `target_currency`: The currency you want to convert to (e.g., EUR). (Target currency can only be EUR, because it's the only one allowed by the free subscription on fixer.io)
- `value`: The amount of the source currency to be converted.

The application will use the exchange rates provided by [fixer.io](https://fixer.io/) to perform the conversion and store the result in the PostgreSQL database.

Example request:

```http
POST /api/convert
Content-Type: application/json

{
  "source_currency": "USD",
  "target_currency": "EUR",
  "value": 100
}
```
The response will include the converted amount and other relevant information. You can see the converted amount on the screen.

## Accessing the Database with pgAdmin
The PostgreSQL database used by the application can be accessed using pgAdmin. Follow these steps to connect to the database with pgAdmin:
1. Open your web browser and navigate to http://localhost:5051.
2. Log in to pgAdmin with the following credentials:
   - `Username`: dragana@example.com
   - `Password`: postgres
3. In the pgAdmin dashboard, click on `Add New Server`
   - Enter a name for the server (e.g., "Currency Conversion Database").
   - In the "Connection" tab:
     - `Host name/address`: 127.0.0.1 (the name of the PostgreSQL container)
     - `Port`: 5432
     - `Maintenance database`: postgres
     - `Username`: postgres
     - `Password`: postgres
   - Click "Save" to save the server configuration.
4. In the pgAdmin dashboard, you will now see the newly added server. You can expand it to access the database and view the tables, including the one where conversion data is stored.

## Unit testing
The application includes unit tests to verify the functionality of the endpoint. You can run the tests by entering the following command inside the easytest-php container:
 ```bash
    - php artisan config:clear
    - php artisan test
   ```
This will execute the unit tests and display the results.

## Project structure
The project structure follows the Laravel framework conventions. Important files and directories include:
- `app`: Contains the application logic.
- `database`: Stores database-related files and migrations.
- `routes`: Defines the application's routes, including the currency conversion endpoint.
- `tests`: Contains unit tests for the application.


