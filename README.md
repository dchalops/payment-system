# Payment System API

This is a payment system built with Laravel. Provides an API to manage payments and their related operations.

## Previous requirements

To run this project locally, you will need:

- PHP 8.0 or higher
- Composer (dependency manager for PHP)
- MySQL or SQLite (or other Laravel compatible database)

## Project Settings

Follow these steps to configure and run the project locally:

### 1. Clone the Repository

Clone the repository from GitHub:

bash
git clone https://github.com/dchalops/payment-system.git

### 2. Install the Dependencies
Go to the project directory and run Composer to install the dependencies:

### 3. Configure the .env File
Copy the example file .env.example and rename it to .env:

cp .env.example .env

#### File .env
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:8WD8qWXH8Jwwe0sv942vpmm6XnAfRSuJcWBw3pNVLlc=
    APP_DEBUG=true
    APP_URL=http://localhost

    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=payment_system
    DB_USERNAME=root
    DB_PASSWORD=

    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    FILESYSTEM_DISK=local
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120

    MEMCACHED_HOST=127.0.0.1

    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    MAIL_MAILER=smtp
    MAIL_HOST=mailpit
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"

    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=
    AWS_USE_PATH_STYLE_ENDPOINT=false

    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_HOST=
    PUSHER_PORT=443
    PUSHER_SCHEME=https
    PUSHER_APP_CLUSTER=mt1

    VITE_APP_NAME="${APP_NAME}"
    VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    VITE_PUSHER_HOST="${PUSHER_HOST}"
    VITE_PUSHER_PORT="${PUSHER_PORT}"
    VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
    VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

    DB_CHARSET=utf8mb4
    DB_COLLATION=utf8mb4_unicode_ci

    JWT_SECRET=B20bAI9M6v2GckLbYKaRNHWIJnzY9vo94pqlwyny2hnKo4JTeACbeeqtSYcFchFt


php artisan migrate

### 5. Start the Local Server
To start the server locally, use the php artisan serve command with the desired address and port:
host= local IP
php artisan serve --host=***.***.**.* --port=8000

## API usage
Once the server is up and running, you can access the API at the address http://172.20.10.2:8000.

To interact with the API, you can use tools like Postman or cURL. Here are some examples of how to use the API:

To interact with Postman you must import the collection that is attached to the project

### Get Payments
To obtain a list of payments:

curl http://172.20.10.2:8000/payments

### Create a Payment
To create a new payment, use a POST request:
curl -X POST -H "Content-Type: application/json" -d '{
  "client_id": 1,
  "description": "Payment for services",
  "amount": 100.00,
  "user_id": 1,
  "payment_method_id": 1
}' http://172.20.10.2:8000/payments/processPayment

### Get Payment Details
To obtain details of a payment by ID:

curl http://172.20.10.2:8000/payments/1

# Contribute to the Project
If you wish to contribute to this project, follow these guidelines:

Create a new "branch" for your changes.
Make sure the code is clean and follows best practices.
Submit a pull request for review.