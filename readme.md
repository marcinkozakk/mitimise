# Mitimise - ZTW Project
Author: Marcin Kozak

## About
Mitimise is a web application that simplifies organising meetings.
 
## Technologies
**Language** PHP7

**Framework** Laravel

**Database** MySQL

## Installation

### Windows users:

1. Download [wamp](http://www.wampserver.com/en/)
2. Download and extract [cmder mini](https://github.com/cmderdev/cmder/releases/download/v1.1.4.1/cmder_mini.zip)
3. Update windows environment variable path to point to your php install folder ([inside wamp installation](dirhttp://stackoverflow.com/questions/17727436/how-to-properly-set-php-environment-variable-to-run-commands-in-git-bash))

cmder will be refered as console

### Mac Os, Ubuntu and windows users continue here:

1. Create a database locally named `mitimise` utf8_general_ci
2. Download [composer](https://getcomposer.org/download/)
3. Pull Mitmise project from git provider `git clone https://github.com/marcinkozakk/mitimise.git`.
4. Rename `.env.example` file to `.env` inside your project root and fill the database information. (windows wont let you do it, so you have to open your console cd your project root directory and run mv .env.example .env )
5. Open the console and cd your project root directory
6. Run `composer install` or `php composer.phar install`
7. Run `php artisan key:generate`
8. Run `php artisan migrate`
9. Run `php artisan serve`
##### You can now access your project at localhost:8000 :)

## Docs
See `/docs` folder or [GitHub page](https://marcinkozakk.github.io/mitimise/)