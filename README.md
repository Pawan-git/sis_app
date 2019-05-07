SiSApp: Expense Entry System
===============================
A demo application to feed employee expense from a pipe-separated (PSV) file and to get monthly expense report on web page.
 
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

Installation
--------------

Download the git repo and place it in htdocs directory inside xampp
OR you may clone the git repo in a directory.

Set the `base_url` inside `app/application/config.php` file.
The `base_url` must be the path upto `app/` folder ex. 'http://localhost/sisapp/app/'

### Database Creation

* Create a database with name `sis_psvapp`.
* Create DB Schema:
	``` 
	To create DB schema and data seed you can either use sql file `sis_psvapp.sql`
	```
	OR 
	```
	Run migrations( See Run Migrations section below).
	```
### Run Migrations

Goto the directory `vendor/bin` and then run the below commands:
* Create tables in database `sis_psvapp`
``` 
phinx migrate -e development -c phinx_config.php 
```
* Seed userdata in `user` table
``` 
phinx seed:run -s UserSeeder -e development -c phinx_config.php 
```
******************************************

### Run the application in your web browser

Try to run the url: 'http://localhost/sisapp/app/'

* Login credentials for `Admin` account:
```
Username: admin
Password: sisadmin
```
* Login credentials for user or `Employee` account:
```
See users listing page in admin interface.
Password is same as username.
```
There is an option for "password update" in user interface, so they can update password after first time logged in. 
We are generating username for employees by using "employee_name" and "employee_address" fields in uploaded psv file.

*******************************************

``` .htaccess ``` file in app folder will look like this:
```
RewriteEngine On
RewriteBase /sisapp/app/   #you might be need to change this path according to your folders
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]

```