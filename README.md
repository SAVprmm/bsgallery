<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 BS Gallery</h1>
    <br>
</p>

REQUIREMENTS
------------

1. The minimum requirement by this project template that your Web server supports PHP 5.6.0.
2. php_exif extension


INSTALLATION
------------

1. Install PHP on Windows (on develope used 7.2.3)
   enable next extension
   ```
   extension=bz2
   extension=curl
   extension=fileinfo
   extension=gd2
   extension=gettext
   extension=imap
   extension=mbstring
   extension=exif
   extension=mysqli
   extension=openssl
   extension=pdo_mysql
   ```
3. Clone git or download and unpack it.
4. Install via composer.json
    ```
    composer update  
    ```
5. Create database and user/pass
6. Create table ***bs_gallery***
  ```sh
  CREATE TABLE `bs_gallery` (
    `id` int(10) UNSIGNED NOT NULL,
    `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `file_date` datetime DEFAULT NULL,
    `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
  ```




CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```


TESTING
-------

Tests (phpunit) do not required by test task.

### Running  acceptance tests

To execute demo on local Windows:  

1. Start web server:

    ```
    yii.bat serve
    ```

2. home page is viewer of gallery

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

