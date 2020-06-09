Safari
====================================
download and install [composer,xampp]
====================================
create your mySQL Database
====================================
create .env file and copy .env.example in it, update it with your credentials
====================================
config the project to your db
DB_DATABASE=your_Database_Name
DB_USERNAME=your_Database_username
DB_PASSWORD=your_Database_password
====================================
open the project directory in your cmd
run=> composer install
run=> npm install
run=> php artisan key:generate
run=> php artisan migrate
run=> php artisan serve
====================================
update database migrations
run=> php artisan migrate:fresh
====================================
