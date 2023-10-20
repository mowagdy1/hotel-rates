# Hotel Rates BI Tool

This project is a simple BI tool for managing and visualizing hotel rates data. It's built using Laravel 10 for the backend and Vue 3 with Vite for the frontend.

## System Requirements

- Docker and Docker Compose

## Setup

1. **Clone the repository**

    ```
    git clone https://github.com/mowagdy1/hotel-rates.git
    cd hotel-rates
    ```

2. **Build and run the Docker containers**

    ```
    docker-compose up -d --build
    ```

3. **Run migrations and seeders**

    ```
    docker-compose exec app php artisan migrate --seed
    ```

Your app should now be running on [http://localhost:8080](http://localhost:8080).

## Usage

The application has two main tabs:

1. **Dashboards**: This is a simple line chart that shows the Rate per night from today to 365 days in the future, daily.

2. **Raw data**: This is paginated table data. The user should be able to query by a given date or just tab through page by page.


## Ingestion Service

There is an ingestion service that runs every day at 1AM EST. This service scrapes 4 hotel booking websites (A, B, C, D) per customer and pulls data. The data is then stored in the database for further analysis by the BI tool.

To run the ingestion service manually, you can use the `docker-compose exec app php artisan scrape:hotel-rates` command.
