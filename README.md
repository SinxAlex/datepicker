# Test widget DatePicker  Yii2
## Example use 
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
