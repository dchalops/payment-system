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