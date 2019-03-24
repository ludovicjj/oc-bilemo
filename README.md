# BileMo
 
 [![Codacy Badge](https://api.codacy.com/project/badge/Grade/ad1770f19bae44ed848a1d74857c3712)](https://www.codacy.com/app/ludovicjj/oc-bilemo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ludovicjj/oc-bilemo&amp;utm_campaign=Badge_Grade)
 
 BileMo is an api REST for provide catalog of phone for their clients. Each clients can manage their catalog of users.
 
## Project using
*   PHP 7.2
*   Symfony 4.2
*   Doctrine
*   Behat
*   LexikJWTAuthentication
*   JMSSerializer
*   BazingaHateoas

## How to instal
 1. Download project :
 
    ``` 
    git clone https://github.com/ludovicjj/oc-bilemo.git
    ```

 2. Install Dependencies :

    ```
    composer install
    ```
 
 3. Generate the private and public SSH keys :
     ```
     $ mkdir -p config/jwt
     $ openssl genrsa -out config/jwt/private.pem -aes256 4096
     $ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
     ```
 
 4. Database :
 
    The database connection information is stored as an environment variable called DATABASE_URL. You can find and customize this inside .env 
    Replace ```db_user``` by your username and  ```db_password``` by your password. Replace ```db_name``` by your database's name as you want.
    ``` 
    DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
     ```

 5. Create database : 
    ```
    php bin/console doctrine:database:create
    ```

 6. Install fixtures :
    ```
    php bin/console doctrine:fixtures:load
    ```
    
 7. Project launch :
    ```
    php bin/console server:run
    ```
## How to use :
 * First, run project and register you as a new client. 
   
   Go to ^/api/clients with Method POST. 
   
   Define your username, password and email in payload :
   ```
   {
     "username": "string",
     "password": "string",
     "email": "user@example.com"
   }
   ```
   
 * Now you can login. 
   
   Go to ^/api/login/client with Method POST.
   
   Provide your username and password in the payload :
   ```
   {
        "username": "string",
        "password": "string",
   }
   ```
   
   For more options check api's documentation.
    
## Documentation

  For view api's doc run project in local and got to ^/api/doc
  
## Test
 1. Create your database for the test env with the following command
    ```
    php bin/console doctrine:database:create --env=test
    ```
 
 2. Run the following command with this tags for launch test
    ```
    vendor/bin/behat --tags=api_all
    ```
    