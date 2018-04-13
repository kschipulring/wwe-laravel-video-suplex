# wwe-laravel-video-suplex
Upload videos with this Laravel form.

This is only a demostration for certain parties and not intended to be used without the author's permission.


Sample Version of this app:
http://3ringprototype.com/wwe-laravel-video-suplex/video-uploader/


You are welcome to create your own account to test and verify for yourself the functionality of this Laravel based web app.  You will need to do this from the registration link.  After you register, you should recieve an email to the account that you give.  From there, you may hit the link within the email to be able to log in and even upload your own videos.


### TECH REQUIREMENTS
- XAMPP, WAMPP, MAMP, LAMP or some other combination of Apache (or NGINX if you are brave), MySQL and PHP 5.6+.
- Your version of Apache should be compatible with .htaccess and allow mod_rewrite
- Knowledge of a currently working MySQL username and password.  You will need to place this in your .env files.  And of course, the MySQL user (core MySQL user, not to be confused with a user for this application) will have to exist in advance.
- Composer for ability to common Laravel commands and install 'Vendor' folder dependencies.  For Javascript, Node and NPM developers, this has a similar role to NPM commands, 'node_modules' folder and the package.json configuration file.  But Composer has its own .json file that performs this role.
- Git command line (git bash), but that is fairly obvious, especially, if you are already visiting Github.com.
- an email account with working password, known connection type and port.  If you find this sort of thing to be a hassle, then perhaps try an existing (but expendable) gmail account

### SETUP in your own environment

1. checkout this repository
2. if you do not yet have it, please install Composer: https://www.getcomposer.org
3. in your command line, please navigate to the **'video-uploader'** folder
4. run the following command to install dependencies:
**php composer.phar install**

5. configure your own .env files.  This app uses both a *.local.env* and also a *.production.env* file for different server environments. **.env.example** from the main part of the directory is a good file to work on.
- Unfortunately, for security reasons, I do not have my own actual .env files as part of this repository.
-The system currently decides on which of these 2 files based on which domain it detects itself to be from */bootstrap/environment.php* around lines 20 and 21.  Obviously for your own non localhost environment, you need to change the switch statement present to something other than the *'3ringprototype.com'* domains.  Those are for our server and not anyone elses. Replace these domains listed here with whatever dot com domain you plan to use *(without 'http://' or 'www' or anything else not part of your core domain or subdomain that you would use for this project)*.
- You will need to get the correct email server settings (as mentioned above).  You will need to change the following:

>MAIL_DRIVER=smtp

>MAIL_HOST=mailtrap.io

>MAIL_PORT=2525

>MAIL_USERNAME=null

>MAIL_PASSWORD=null

>MAIL_ENCRYPTION=null

... to settings that apply to your desired account.

6. Database Setup.  **Required:** pre-existing database with correctly configured db user and password (for both below scenarios) 
 - 1. Migration technique.  Navigate to 'database/migrations' folder within the 'video-uploader' folder.  Move files from the *'old'* folder to the main parent *'migrations'* folder.
 - 2. run following command in the command line: **php artisan migrate**.  This creates the tables with the schemas on the database.  If you run into an issue, which occurs right after migrating users sometimes, then move the users and create_password migration files back to the 'old' directory.  Afterwards, run **php artisan migrate** again.  This should do the remaining migrations.
 
 - **or**
 - Schema import from attached 'schema.sql' file.  Hopefully, you have something to manage your databases such as 'PHPmyAdmin', 'Navicat' or 'MySQL Workbench'.  Using this, pick your desired database as mentioned above (and referenced in your .env files).  Import the 'schema.sql' file into your database.  Also for security reasons, there is no actual data in this .sql file.
 
7. On your desired server where all this has been installed, navigate to the respective folder from the server for wwe-laravel-video-suplex/video-uploader.
