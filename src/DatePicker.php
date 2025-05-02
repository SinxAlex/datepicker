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

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
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


        if ($this->hasModel() && $this->model->{$this->attribute}) {
            $this->value = Yii::$app->formatter->asDate($this->model->{$this->attribute}, $this->format);
            $this->options['value'] = $this->value;
        }

        $input = $this->hasModel()
            ? Html::activeTextInput($this->model, $this->attribute, $this->options)
            : Html::textInput($this->name, $this->value, $this->options);

        Html::addCssClass($this->contentOptions, 'input-group');
        return Html::tag('div', $input.'<button class="btn btn-secondary">'.self::ICON_WIDGET.'</button>',$this->contentOptions);
    }

        protected function registerAssets()
    {
        $view = $this->getView();
        DatePickerAsset::register($view);

        $id = $this->options['id'];
        $options = $this->getClientOptions();

        $js = <<<JS
        (function() {
            const tempusDominus = window.tempusDominus;
            const input = document.getElementById('$id');
            
          
            const picker = new tempusDominus.TempusDominus(input, $options);
            
           
            picker.subscribe(tempusDominus.Namespace.events.change, (event) => {
                if (event.date) {
                    const formattedDate = picker.dates.formatInput(event.date);
                    input.value = formattedDate;
                    input.setAttribute('value', formattedDate);
                    const changeEvent = new Event('change', { bubbles: true });
                    input.dispatchEvent(changeEvent);
                }
            });
            
            if (input.value) {
                picker.dates.set(tempusDominus.DateTime.convert(input.value));
           
                input.setAttribute('value', input.value);
            }
        })();
        JS;

        $view->registerJs($js);
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

        $formatMap = [
            'd' => 'dd',
            'm' => 'MM',
            'Y' => 'yyyy',
            'y' => 'yy',
        ];

        return strtr($this->format, $formatMap);
    }

    protected function getLocale()
    {
        return str_replace('_', '-', Yii::$app->language);
    }
}