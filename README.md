# Test widget DatePicker  Yii2

[![Yii2](https://img.shields.io/badge/Yii-2.0.x-blue?logo=yii&style=flat-square)](https://www.yiiframework.com/)


### Install :
composer require sinxalex/datepicker


### Example use :
```php
   <?php
    echo \sinxalex\datepicker\DatePicker::widget([
        'name' => 'Test',
        'value' => '',
        'format' => 'd.m.Y', // явно указываем нужный формат
        'clientOptions' => [
            'button'=>true,
            'class'=>'btn btn-secondary',
            'position'=>'left',
        ]
    ]);
?>
```
