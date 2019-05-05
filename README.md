SiSApp: Expense entry system
===============================

 A demo application to feed employee expense from a pipe-separated (PSV) file and to get monthly expense report on web page.
 ```````````````````````````````````````````````
DIRECTORY STRUCTURE
-------------------

```
app
    application/            Contains the application source code files
    assets/                 Contains the assets: css|js
    system/                 contains framework files

db
    migrations/              contains db migrations


vendor/                  contains dependent 3rd-party packages

```


************
Installation
--------------
************

Download the git repo and place it in htdocs directory inside xampp
OR you may clone the git repo in a directory.

Set the 'base_url' inside app/application/config.php file.
The 'base_url' must be the path upto 'app/' folder ex. 'http://localhost/sisapp/app/'

Create a database with name 'sis_psvapp' and then run migrations
Create DB Schema: Use sql file "sis_psvapp.sql" to create DB schema.

************
Run Migrations
--------------
************

Goto the directory vendor/bin
Run the below commands:
#Create tables in database `sis_psvapp`

phinx migrate -e development -c phinx_config.php


***************
Run the application in your web browser
***************

Try to run the url: 'http://localhost/sisapp/app/'

Credentials to login admin account:
Username: admin
Password: sisadmin

***************
.htaccess
***************

*******************************************
``` .htaccess ``` file in app folder will look like this:
*******************************************
```
RewriteEngine On
RewriteBase /sisapp/app/   #you might be need to change this path according to your folders
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]

```
