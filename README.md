# 🤖 Bleep bloop, I'm a bot. Build your own Workplace Messenger bot.

## What is Workplace?

If you never heard about Workplace maybe you should start on the [top 10 questions about Workplace](https://workplaceblog.fb.com/news/workplace-questions/)

## What to expect

When you want to create a custom integration for Workplace, you may find information on the [technical docs](https://developers.facebook.com/docs/workplace/integrations/custom-integrations) that are concise, but not exactly easy follow if you haven't built a bot and hooked it up to your app or page in Workplace or Facebook before. There is more information in the [Complete Guide for the Messenger platform](https://developers.facebook.com/docs/messenger-platform/implementation) and the [Documentation for the Graph API](https://developers.facebook.com/docs/graph-api) but a new developer may find it overwhelming to start with. 

The goal following this tutorial is having a **live stater-app** that implements the Workplace Webhook/Graph API bot. **Deployed to Heroku**,  along the way, you will also learn how to use Heroku's free tier for hacking on projects like this. It **should take between 15 and 30 minutes** depending on prior experience.


## The basics

### Get your Company in a Workplace Premium Instance

1. Custom integrations are only available on Premium tier, you can [sign up for a 90-day free trial](https://www.facebook.com/workplace/pricing/) using your corporate e-mail if your company still is not in Workplace. You are missing a lot of fun!


### Download, build and deploy the project

We also have instructions for [Linux](/public/linux.md) and [Windows](/public/windows.md) for AWS.

1. Get a free [Heroku account](https://signup.heroku.com/) if you haven't already.

2. Install the [Heroku toolbelt](https://toolbelt.heroku.com) which will let you launch, monitor and generally control your instances (and other services like databases) from the command line.

3. [Install PHP 7]  (http://php.net/manual/en/install.php), this will be our server environment. Then open up Terminal (or whatever your CLI might be) and make sure you're running the latest version of composer - the package manager for PHP:

    ```
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    ```

4. Clone this project and switch into the project directory.

    ```
    git clone https://github.com/eduardogomes/wp-chatbot-boilerplate-php.git
    cd wp-chatbot-boilerplate-php
    ```

5. Install PHP dependencies. We are using [Monolog](https://github.com/Seldaek/monolog) for Logging and [DovEnv](https://github.com/vlucas/phpdotenv) for configuration.

    ```
    php composer.phar install
    ```

6. Create a new Heroku instance and push the code to the cloud.

    ```
    heroku create
    git push heroku master
    ```  

7. You should be all set and be able to visit your page at the URL that was output by ```$ heroku create```.


### Setup your Workplace App

1. In the Company Dashboard, open the Integrations tab.
2. Click on the Create App button.
3. Choose a relevant name and description for the app.

    ![Create a new Workplace App](/public/img/documentation-img/create_new_integration.png)

4. Add a profile picture for the app. This will be used any time the app is visually represented, for instance if it makes a post to group.
5. Choose the required [permissions](https://developers.facebook.com/docs/workplace/integrations/custom-integrations/permissions) for the app, based on the integration functionality you require. For this boilerplate implementation you will need only the 'Message any member' permission. To run all integration tests you will need the 'Read Group Content', 'Manage Group Content', 'Manage Groups' and 'Message any Member' permissions.

    ![Create a new Workplace App](/public/img/documentation-img/application-permissions.png)

6. Create, Copy and safely store the [access token](https://developers.facebook.com/docs/workplace/integrations/custom-integrations/permissions#appaccesstoken) that's shown to you. You'll need this when making API calls.

7. Configure your environment variables. You will need to set the data on the ```.env``` file in your local wp-chatbot-boilerplate-php folder

```
PAGE_ACCESS_TOKEN=Bearer <access token, created on step 6 in the format "Bearer TOKEN">
VERIFY_TOKEN= <a unique string to identity your bot, e.g.: dev-workshop-bot-token>
APP_SECRET= <a hexadecimal value created by workplace, used to sign the requests to secure they are coming from Facebook servers>
```

8. Configure the messaging web hook with the Bot URL and the Verify Token (set in the previous step)
    The url should be ```https://<your heroku app name>.herokuapp.com/webhook.php```.

    ![Configure the Webhook](/public/img/documentation-img/webhook-config.png)
        

# ⇨ Go to your Workplace instance find your bot and start chatting. 🤖

## OK, so what now?

- Change the webhook.js file and deploy it to heroku (using ```git push heroku master```), after committing your changes in your local environment 

- [Debug your bot](/public/debug.md) in your local environment

- Deploy your chatbot to a [Docker container](/public/docker.md)

- [Wit.ai](https://wit.ai) is a service that lets you easily create text or voice based bots that humans can chat with on their preferred messaging platform. Basic wit.ai functionality will be baked into this starter app at some point in the future.
