
# Deploy your application to a Linux server in AWS

## Setup your [network components](/networking-aws.md)

## Setup your instance
You can use the following instructions to install this application on a Linux server.

1. Connect to your server using SSH

2. Install the Node Version Manager (NVM), activate it and install Node version 6.11.1

    ```
    curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.32.0/install.sh | bash
    . ~/.nvm/nvm.sh
    nvm install 6.11.1
    ```

3. Install npm and gulp
    ```
    sudo npm install npm -g
    sudo npm install gulp -g
    ```

4. Install git
    ```
    sudo yum install git
    ```

5. Clone this project and switch into the project directory.

    ```
    git clone https://github.com/eduardogomes/wp-chatbot-boilerplate-php.git
    cd wp-chatbot-boilerplate-nphp
    ```

6. Install PHP dependencies. We are using [Monolog](https://github.com/Seldaek/monolog) for Logging and [DovEnv](https://github.com/vlucas/phpdotenv) for configuration.

    ```
    php composer.phar install
    ```

7. Deploy to Apache
    ```
    cp * /var/www/html
    ```

8. Try access the application landing page on http://<your public dns>/