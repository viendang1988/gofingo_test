# Development guide
## 1. Tech stack
- Symfony 6.1.8
- PHP 8.1
- MySQL 8.0.29

## 2. Build code
- Run composer to build vendor
  ``composer install``

- Define your `.env.local` by coping from .env

  ### Config Database
  ```
  MYSQL_USER=
  MYSQL_PASSWORD=
  MYSQL_DATABASE=
  MYSQL_VERSION=
  MYSQL_HOST=
  MYSQL_PORT=
  ```
  ### Config SMTP and email from/to
  ```
  MAILER_SMTP=
  MAILER_PORT=
  MAILER_FROM=
  MAILER_TO=
  MAILER_USERNAME=
  MAILER_PASSWORD=
  ```
## 3. Migrate Database
  - Create the database
  - Run this command to create tables
  ```shell
    bin/console doctrine:migrations:migrate
  ```

## 4. How to use
  ### Insert/Update data from JSON files
  json files will be store in

  ```
  /resources/categories.json
  /resources/products.json
  ```
  Run this command to insert/update data into database
  ```shell
    bin/console app:update-database
  ```

  ### Crud for Product
  Start web server, example http://localhost:8000
  ```
  symfony serve
  ```

  Access this link to create/edit/remove/view product `http://localhost:8000/product`
