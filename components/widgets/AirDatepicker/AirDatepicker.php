<?php

namespace app\components\widgets\AirDatepicker;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\helpers\Html;

class AirDatepicker extends InputWidget
{
	public $language;

	public $clientOptions = [];
	public $containerOptions = [];

	public $addonAppend = '<div class="input--datepicker__icon"></div>';

	public $dateFormat = 'dd.mm.yyyy';

	public $inline = false;

    public function run()
    {
	    echo $this->renderWidget() . PHP_EOL;

	    $containerID = $this->inline ? $this->containerOptions['id'] : $this->options['id'];
	    $language = $this->language ? $this->language : Yii::$app->language;

	    $this->clientOptions['language'] = $language;

	    if (!isset($this->clientOptions['dateFormat'])) {
		    $this->clientOptions['dateFormat'] = $this->dateFormat;
	    }

	    if (!isset($this->clientOptions['altFormat'])) {
		    //$this->clientOptions['altFieldDateFormat'] = $this->dateFormat;
	    }

	    if (!isset($this->clientOptions['altField'])) {
		    //$this->clientOptions['altField'] = '#' . $containerID;
	    }

	    if (!isset($this->clientOptions['autoClose'])) {
		    $this->clientOptions['autoClose'] = true;
	    }

	    $options = Json::htmlEncode($this->clientOptions);

	    $view = $this->getView();
	    $pickerVar  = md5($containerID);
	    //$view->registerJs("$('#{$containerID}').datepicker({$options});");
	    $view->registerJs("	   
	       var picker_{$pickerVar} = $('#{$containerID}').datepicker({$options}).data('datepicker');

            $('#{$containerID}').parent().on('click' , function(){                   
                that = $(this);
                if(that.hasClass('is-active')){
                    picker_{$pickerVar}.hide();
                    that.removeClass('is-active');
                }else{
                    picker_{$pickerVar}.show();
                    that.addClass('is-active');
                }
            })
	    ");

	    AirDatepickerAssets::register(Yii::$app->controller->view);
    }

	protected function renderWidget()
	{
		$contents = [];
		$options = $this->options;

		if (isset($options['value'])) {
			$value = $options['value'];
		} else if ($this->hasModel()) {
			$value = Html::getAttributeValue($this->model, $this->attribute);
		} else {
			$value = $this->value;
		}

		if ($value == 0) {
			$value = '';
		}

		$options['value'] = $value;

		if (!isset($this->containerOptions['class'])) {
			$this->containerOptions['class'] = 'input--datepicker lk-form--datepicker-md js-datepicker';
		}

		$contents[] = Html::beginTag('div', $this->containerOptions);

		if ($this->inline === false) {
			// render a text input
			if ($this->hasModel()) {
				$contents[] = Html::activeTextInput($this->model, $this->attribute, $options);
			} else {
				$contents[] = Html::textInput($this->name, $value, $options);
			}
		} else {
			// render an inline date picker with hidden input
			if ($this->hasModel()) {
				$contents[] = Html::activeHiddenInput($this->model, $this->attribute, $options);
			} else {
				$contents[] = Html::hiddenInput($this->name, $value, $options);
			}

			$this->clientOptions['startDate'] = $value;
		}

		$contents[] = Html::endTag('div');

		return implode("\n", $contents);
	}
}