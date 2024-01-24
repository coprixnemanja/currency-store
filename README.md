## About

Simple Laravel Htmx application that enables the purchase of a number different currencies using USD.

## Setup

1. Clone repository:
    1. Clone the repository ```git clone https://github.com/nmilink/currency-store.git```
    2. Navigate to project folder ```cd currency-store```
2. Install composer dependencies
    1. ```composer install --dev```
3. Setup ```.env``` file:
    1. Create the ```.env``` file from the example file ```cp example.env .env```
4. Setup database:
    1. Create new database and past name as the value of ```DB_DATABASE``` inside the ```.env``` file
    2. Set password ```DB_PASSWORD``` and username ```DB_USERNAME``` inside the ```.env``` file to be able to connect to your database.
    3. Configure ```DB_HOST```, ```DB_PORT``` and ```DB_CONNECTION``` if you are not hosting your database as mysql on localhost on port 3306
    4. Run command ```php artisan migrate```
    5. Run command ```php artisan db:seed``` (populate the 3 currencies from the assignment)
5. Setup CurrencyLayer:
    1. Sign Up here [a link](https://currencylayer.com)
6. Run ```php artisan serve``` and follow the link.


## DISCLAIMER

### Before running the automated test make sure the database specified in the ```.env``` file is a development database.
### Automated tests use ```RefreshDatabase```, so on every run of any automated test the whole database is wiped and re-migrated.
## (ALL DATA LOST)

## Testing

- To run the unit and feature tests run command ```php artisan test```


