# Mellodian website
to run the web project follow the instructions below:
Please ensure that the database name is created before populating the database. the database name for this project is mellodian. This can be changed in the .en file.
to populate the database choose one of the two methods:
------------------------------------------------------------
Option 1: using laravel seeders:
migrate and run all seeders
php artisan migrate:fresh --seed
------------------------------------------------------------
Option 2: using mellodian.sql file to populate database.
Locate the  mellodian.sql in the project root directory.
Go to PHP my admin and select the mellodian database and upload the sql file.
------------------------------------------------------------
the database should now be populated with the table structure and data from one of the two selected methods chosen.

to run the server use:
php artisan serve
------------------------------------------------------------
for a list of commands refer to the commands.txt file.


