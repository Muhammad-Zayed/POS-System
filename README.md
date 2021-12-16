## POS System
This is a multilanguage POS system .

## Live Project
* link  :  http://zayed.infinityfreeapp.com 
* credentials :
    * Email : ` super_admin@app.com `
    * password  : ` 123456 `


## Used Packages
1- Laravel mcamara : Used for manipulating localization .
2- Laratrust : Used for roles and permissions .
3- Image intervention : Used for manipulating images such as resizing and compressing .


## Installation

1- Clone the project or download the zip file .

2- Open the project folder and run the following commands sequentially : 
* install dependencies : 
```
composer install 
```

* Rename ` .env.example ` file to ` .env ` and run this command :
```
php artisan key:generate
```

* Create database then update the .env file with your database credentials in this part :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```


* run the migrations and seeder with this command :
```
php artisan migrate --seed
```

* run the project with this command 
```
php artisan serve 
```

* finally you can login with this credentials :
    * Email : ` super_admin@app.com `
    * password  : ` 123456 `






