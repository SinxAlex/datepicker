# Test widget DatePicker  Yii2

[!input Yii2](https://www.yiiframework.com/doc/api/2.0/yii-widgets-inputwidget)
## Example use :
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
