# wwe-laravel-video-suplex
Upload videos with this Laravel form.

This is only a demostration for certain parties and not intended to be used without the author's permission.


Sample Version of this app:
http://3ringprototype.com/wwe-laravel-video-suplex/video-uploader/


You are welcome to create your own account to test and verify for yourself the functionality of this Laravel based web app.  You will need to do this from the registration link.  After you register, you should recieve an email to the account that you give.  From there, you may hit the link within the email to be able to log in and even upload your own videos.


#TECH REQUIREMENTS
- XAMPP, WAMPP, MAMP, LAMP or some other combination of Apache (or NGINX if you are brave), MySQL and PHP 5.6+.
- Knowledge of a currently working MySQL username and password.  You will need to place this in your .env files.  And of course, the MySQL user (core MySQL user, not to be confused with a user for this application) will have to exist in advance.
- Composer for ability to common Laravel commands and install 'Vendor' folder dependencies.  For Javascript, Node and NPM developers, this has a similar role to NPM commands, 'node_modules' folder and the package.json configuration file.  But Composer has its own .json file that performs this role.
- Git command line (git bash), but that is fairly obvious, especially, if you are already visiting Github.com.

#SETUP in your own environment

1. checkout this repository
2. if you do not yet have it, install Composer: https://www.getcomposer.org
3. in your command line, please navigate to the 'video-uploader' folder
4. run the following command:
**php composer.phar install**
