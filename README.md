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
    
### Demonstration of the result

1. Home page is viewer of gallery
    <a href="https://github.com/SAVprmm/bsgallery/blob/main/tests/screenshots/1.home_page-viewer.jpg" target="_new">demo screenshot 1</a>

2. After successed added 5 images of different format
    <a href="https://github.com/SAVprmm/bsgallery/blob/main/tests/screenshots/2.add_5_image_with_success.jpg" target="_new">demo screenshot 2</a>

3. How displaying error of uploading 
    <a href="https://github.com/SAVprmm/bsgallery/blob/main/tests/screenshots/3.add-_with_error_due_wrong_file_type.jpg" target="_new">demo screenshot 3</a>

4. See 5 images sort by "Original Create Date". One of it have original cyrillic name.
    <a href="https://github.com/SAVprmm/bsgallery/blob/main/tests/screenshots/4.added_one_image_name_was_translited.jpg" target="_new">demo screenshot 4</a>

5. See images with the same original name. On right images preview clickable. Pagination on down of page.
    <a href="https://github.com/SAVprmm/bsgallery/blob/main/tests/screenshots/5.on_viewer_image_with_same_name-pagination-sotring.jpg" target="_new">demo screenshot 5</a>
