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
    1. Sign Up here [currency layer](https://currencylayer.com)
    2. Get your API Access Key and paste as the value of ```CURRENCYLAYER_API_KEY``` inside the ```.env``` file
6. Setup mailing service:
    
    1. Set the value of ```MAIL_STATIC_CURRENCY_ORDER``` inside the ```.env``` file to the email address where you want to receive order confirmations.
    2. Create new gmail account or use existing one.
    3. Paste the email address of the google account as the value of ```MAIL_USERNAME``` inside the ```.env``` file
    4. Follow instructions from this [link](https://support.google.com/mail/answer/185833?hl=en) to setup app password four your gmail.
    5. Paste the app password of the google account as the value of ```MAIL_PASSWORD``` inside the ```.env``` file
7. Run ```php artisan serve``` and follow the link.

## Update exchange rates

- Run command ```php artisan app:update-rates```


## DISCLAIMER

### Before running the automated tests make sure the database specified in the ```.env``` file is a development database.
### Automated tests use ```RefreshDatabase```, so on every run of any automated test the whole database is wiped and re-migrated.
## (ALL DATA LOST)

## Testing

- To run the unit and feature tests run command ```php artisan test```
- After running the tests make sure to run ```php artisan db:seed``` to populate the necessary data.


