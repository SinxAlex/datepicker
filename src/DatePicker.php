<?php
namespace  sinxalex\datepicker;
use sinxalex\datepicker\assets\DatePickerAsset;
use yii\base\Theme;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;


use Yii;
class DatePicker extends \yii\widgets\InputWidget
{
    const ICON_WIDGET="&#x1F4C5;";

    /**
     * @var array
     * class
     * widget id
     * lang
     *
     */
    public $clientOptions=[];

    /**
     * @var array
     */
    public $options=[];

    /**
     * @var $format
     * format data to view dd.mm.YYYY dd/mm/YYYY .....
     */
    public  $format;

    /**
     * @var $content
     */
    public $content;

    /**
     * @var array
     */
    public $contentOptions=[];


    public  function init()
    {
        parent::init();

        if ($this->format === null) {
            $this->format = 'd.m.Y';
        }

        Html::addCssClass($this->options, 'form-control');

        $this->clientOptions = ArrayHelper::merge([
            'localization' => [
                'locale' => $this->getLocale(),
                'format' => $this->getJsDateFormat(),
            ],
        ], $this->clientOptions);
    }


    public  function run(){

       $this->registerAssets();
        echo $this->renderInput();
    }

    protected function renderInput()
    {

       Html::addCssClass($this->options, 'form-control');
       $input = $this->hasModel() ? Html::activeTextInput($this->model, $this->attribute, $this->options) : Html::textInput($this->name, $this->value, $this->options);
       Html::addCssClass($this->contentOptions, 'input-group');
       return Html::tag('div', $input.'<button class="btn btn-secondary">'.self::ICON_WIDGET.'</button>',$this->contentOptions);
    }

        protected function registerAssets()
    {
        $view = $this->getView();
        DatePickerAsset::register($view);

        $id = $this->options['id'];
        $options = $this->getClientOptions();
        $phpFormat = $this->format;
        $jsFormat = $this->getJsDateFormat();

        $js = <<<JS
    (function() {
        const tempusDominus = window.tempusDominus;
        const input = document.getElementById('$id');
        
        // Инициализация пикера
        const picker = new tempusDominus.TempusDominus(input, $options);
        
        // Функция для форматирования даты в нужный формат
        function formatDate(date, format) {
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            
            return format
                .replace('d', day)
                .replace('m', month)
                .replace('Y', year)
                .replace('y', year.toString().slice(-2));
        }
        
        // Обработка изменения даты
        picker.subscribe(tempusDominus.Namespace.events.change, (event) => {
            if (event.date) {
                input.value = formatDate(event.date, '$phpFormat');
            }
        });
    })();
    JS;

        $view->registerJs($js);
    }

    protected function getClientOptions()
    {

        return Json::encode([
            'localization' => [
                'locale' => Yii::$app->language,
                'format' =>  $this->getJsDateFormat(),
            ],
            'display' => [
                'theme' => 'light',
                'buttons' => [
                    'today' => true,
                    'clear' => true,
                    'close' => true,
                ],
            ],
        ]);
    }
    protected function getJsDateFormat()
    {
        return 'dd.MM.yyyy'; // Фиксированный формат, совместимый с Tempus Dominus
    }

    protected function getLocale()
    {
        return str_replace('_', '-', Yii::$app->language);
    }
}