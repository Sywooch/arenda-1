<?php

namespace app\components\widgets\CustomDropdown;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\helpers\Html;

class CustomDropdown extends InputWidget
{
	public $items = [];
	public $containerOptions = [];

	public function run()
	{
		echo $this->renderWidget() . PHP_EOL;
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

		if (empty($value) || $value == '' || $value == null) {
			reset($this->items);
			$value = key($this->items);
			$this->model->{$this->attribute} = $value;
		}

		if (!isset($this->containerOptions['class'])) {
			$this->containerOptions['class'] = 'selector lk-form--select-md selector-color--m js-selector';
		}

		$contents[] = Html::beginTag('div', ['class' => $this->containerOptions['class']]);

		$contents[] = Html::beginTag('div', ['class' => 'selector__head js-selector-current-option-wrap']);

		// render an hidden input
		if ($this->hasModel()) {
			$contents[] = Html::activeHiddenInput($this->model, $this->attribute, $options);
		} else {
			$contents[] = Html::hiddenInput($this->name, $value, $options);
		}

		$selectedValue = (isset($this->items[$value])) ? $this->items[$value] : reset($this->items);

		$contents[] = Html::tag('span', $selectedValue, ['class' => 'selector__option-current js-selector-current']);
		$contents[] = Html::tag('span', '', ['class' => 'selector__option-icon']);
		$contents[] = Html::endTag('div');

		$contents[] = Html::beginTag('ul', ['class' => 'selector__options-list js-selector-options']);
		foreach ($this->items as $key => $value) {
			$contents[] = Html::tag('li', $value, [
				'class'            => 'selector__option js-selector-option',
				'data-option-name' => $key,
			]);
		}
		$contents[] = Html::endTag('ul');

		$contents[] = Html::endTag('div');

		return implode("\n", $contents);
	}
}