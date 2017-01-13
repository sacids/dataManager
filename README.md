[![Build Status](https://travis-ci.org/sacids/dataManager.svg?branch=development)](https://travis-ci.org/sacids/dataManager)

# Afyadata Manager

A guide to getting started contributing on this project

#### Prerequisites
1. Make sure you have Apache server or XAMPP installed
2. PHP version 5.4 and above is required
3. MySQL database installed
4. `php-cli` is required to execute php files on command line 
 
 
Clone this project to your local machine from [SACIDS Afyadata Manager](https://github.com/sacids/afyadata)

##### Setting up your database
 - Create a MySQL database
 - Change database username, password and database name in `database.php` file located under `application/config/database.php`
 - To initialize database base tables open terminal mac or linux or command prompt (CMD) on windows on and navigate to the root or your directory and run `$ php index.php migration latest`

All the tables will be created and you can start contributing on the project right away.


##### How to open application 
* If you have successfully migrated your database follow below instructions.
* Open your favorite web browser and type `http://localhost/<your-project-directory>`
* Login with username as `admin` and password as `sacidsdemo`

[Click to learn more how to contribute on this project](https://github.com/sacids/afyadata/blob/master/contributing.md)


##### Seeding data 
* If you have successfully migrated your database follow below instructions.
*  To run this download and install [composer](https://getcomposer.org) if you have composer installed continue to step two below
* Then run `$ composer update` to get dependencies
* Open terminal or command line interface
* Navigate to root directory of your project (`i.e afyadata`)
* Then run `$ php index.php seeder seed` to get dummy data generated
* You can adjust limit at any time to fit the number of records you want at `controllers/Seeder.php`
    





