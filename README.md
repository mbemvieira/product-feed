# product-feed

Fetch products list from several providers and present it through API.

## Architecture

1- Using Lumen's queues and jobs to create asynchronous requests to providers. This prevents external API failures to break the entire application or to spend a lot time waiting for response. The main drawback is the higher code complexity and the need of a database to store a copy of the requested data locally.

2- Using a centralized Providers Manager, it is possible to handle all the registered providers in one place and call each one of them in a loop.

## Environment Requirements

Check Lumen 8.x documentation for environment requirements.

## Installation

Clone this repo into your machine:

```bash
git clone https://github.com/mbemvieira/product-feed
```

Inside your repo folder, run the following commands:

```bash
composer install
cp .env.example .env
```

Inside .env file:

- Generate a key. Go to the /key endpoint and fill the APP_KEY variable with the generated string.
- Set your database configuration and credentials.
- Set the provider credentials (EBAY_CREDENTIALS).
- Set the QUEUE_CONNECTION variable (usually, database or sync).

Run migrations.

```bash
php artisan migrate
```

Run your php server locally

```bash
php -S localhost:8000 -t public
```

## API Reference

```
GET <APP-HOSTNAME>/products
```

Query string parameters:

- keywords: required
- price_min: required_with:price_max|numeric
- price_max: required_with:price_min|numeric'
- sorting: 'default'|'by_price_asc'
