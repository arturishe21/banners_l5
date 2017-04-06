
В composer.json добавляем в блок require
```json
 "vis/banners_l5": "1.0.*"
```

Выполняем
```json
composer update
```

Добавляем в app.php
```php
   Vis\Banners\BannersServiceProvider::class,
```

и в aliases
```php
'Banner' => 'Vis\Banners\Banner',
```
Выполняем миграцию таблиц
```json
   php artisan migrate --path=vendor/vis/banners_l5/src/Migrations
```

Публикуем js файлы
```json
   php artisan vendor:publish --tag=banners --force
```

В файле config/builder/admin.php в массив menu добавляем
```php
 	array(
        'title' => 'Баннера',
        'icon'  => 'crop',
        'submenu' => array(
            array(
                'title'   => 'Баннера',
                'link'    => '/banners/banners_all',
                'check' => function() {
                    return true;
                }
            ),
            array(
                'title' => 'Баннерные площадки',
                'link'  => '/banners/area',
                'check' => function() {
                    return true;
                }
            ),

        ),
    ),
```