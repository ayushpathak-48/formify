Formify - Google Forms Clone in PHP

To run the project follow below steps: Make sure you follow below steps otherwise the code will not work perfectly

step 1: unzip the formify zip file
step 3: start apache and mysql service in xampp
step 4: open http://localhost/phpmyadmin
step 5: create a database : name = formify
step 6: import sql file in phpmyadmin from the database folder of unzipped file
step 7: copy the code folder in unzipped folder of formify
step 8: paste it in c://xampp/htdocs in your local machine and rename the code folder to formify
step 9: open the link http://localhost/formify
step 10: create a .htaccess file if it does not exist
step 11: paste the below content in it and save the file
step 12: done the project is ready to run

".htaccess file"

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)$ index.php [QSA,L]
```
