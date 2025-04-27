<?php

namespace sinxalex\datepicker\assets;

use yii\web\AssetBundle;

class DatePickerAsset extends AssetBundle
{
    public $css = [
        'https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css',
        'https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/themes/tempus-dominus-light.min.css',
    ];

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js', // 1. Moment.js
        'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js',         // 2. Popper.js
        'https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js', // 3. Tempus Dominus
    ];

    public $depends = [
        'yii\bootstrap5\BootstrapAsset', // Bootstrap 5 CSS
    ];
}