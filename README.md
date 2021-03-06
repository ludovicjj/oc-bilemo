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
1.  Download project :

        git clone https://github.com/ludovicjj/oc-bilemo.git

2.  Install Dependencies :

        composer install

3.  Generate the private and public SSH keys :

        $ mkdir -p config/jwt
        $ openssl genrsa -out config/jwt/private.pem -aes256 4096
        $ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

4.  Database :

    Create file .env.local at root project level. In this file define these parameters

        ###> symfony/framework-bundle ###
        APP_ENV=prod
        APP_SECRET=31039513550d4431f6de1dfc6aecb2ef
        #TRUSTED_PROXIES=127.0.0.1,127.0.0.2
        #TRUSTED_HOSTS='^localhost|example\.com$'
        ###< symfony/framework-bundle ###
        
        ###> doctrine/doctrine-bundle ###
        # Format described at http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
        # For an SQLite database, use: "sqlite:///%kernel.project_dir%/var/data.db"
        # Configure your db driver and server_version in config/packages/doctrine.yaml
        DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
        DATABASE_URL_TEST=sqlite:///%kernel.project_dir%/var/data.db
        ###< doctrine/doctrine-bundle ###
        
        ###> lexik/jwt-authentication-bundle ###
        JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
        JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
        JWT_PASSPHRASE=passphrase
        ###< lexik/jwt-authentication-bundle ###
        
        API_VERSION=1.0.0
    
    The database connection information is stored as an environment variable called DATABASE_URL. You can find and customize this inside .env 
    Replace ```db_user``` by your username and  ```db_password``` by your password. Replace ```db_name``` by your database's name as you want.

        DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

5.  Create database : 

        php bin/console doctrine:database:create

6.  Install fixtures :

        php bin/console doctrine:migrations:migrate
        php bin/console doctrine:fixtures:load

7.  Project launch :

        php bin/console server:run

## How to use
*   First, run project and register you as a new client. 

    Go to ^/api/clients with Method POST. 

    Define your username, password and email in payload :

        {
            "username": "string",
            "password": "string",
            "email": "user@example.com"
        }

*   Now you can login.

    Go to ^/api/login/client with Method POST.

    Provide your username and password in the payload :

        {
            "username": "string",
            "password": "string"
        }

    For more options check api's documentation.
## Documentation
For view api's doc run project in local and got to ^/api/doc
## Test
1.  Create file .env.test at root project level

2.  In .env.test define your env variables for the test env here and add your JWT private and public key and your JWT passphrase

        DATABASE_URL_TEST=sqlite:///%kernel.project_dir%/var/data.db
        
        JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
        JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
        JWT_PASSPHRASE=passphrase

3.  Create your database for the test env with the following command

        php bin/console doctrine:database:create --env=test

4.  Run the following command with this tags for launch test

        vendor/bin/behat --tags=api_all
