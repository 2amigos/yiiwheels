<?php
/**
 *
 * User: tonydspaniard <amigo.cobos@gmail.com>
 * Date: 16/02/13
 * Time: 02:31
 *
 */
class YwHtml extends TbHtml
{
	const INPUT_DATEPICKER = 'datePickerField';
	const INPUT_SELECT2 = 'select2Field';
	const INPUT_TYPEAHEAD = 'typeAheadField';

	static $validInputs = array(
		self::INPUT_DATEPICKER => 'yiiwheels.widgets.datepicker.YwDatePicker',
		self::INPUT_SELECT2 => 'yiiwheels.widgets.select2.YwSelect2',
		self::INPUT_TYPEAHEAD => 'bootstrap.widgets.TbTypeAhead'
	);

	/**
	 * @return mixed
	 */
	public static function validInputs()
	{
		return array_merge(parent::$inputs, array_keys(self::$validInputs));
	}

	/**
	 * Renders a datepicker field
	 * @param $name
	 * @param string $value
	 * @param array $htmlOptions
	 * @return string
	 */
	public static function datePickerField($name, $value = '', $htmlOptions = array())
	{
		$widgetOptions = array('name' => $name, 'value' => $value, 'htmlOptions' => $htmlOptions);

		return self::widget(self::getWidgetPath(self::INPUT_DATEPICKER), $widgetOptions);
	}

	/**
	 * Renders a typeahead field
	 * @param string $name
	 * @param string $value
	 * @param array $htmlOptions additional attributes of the HTML element. Special attributes are supported.
	 * @see YiiStrap.TbTypeAhead for information about the special attributes.
	 * @return string
	 */
	public static function typeAheadField($name, $value = '', $htmlOptions = array())
	{
		$configurationOptions = array('source', 'items', 'matcher', 'sorter', 'updater', 'minLength', 'highlighter');
		$widgetOptions = self::moveOptions(
			$configurationOptions,
			$htmlOptions,
			array());
		$htmlOptions = self::removeOptions($htmlOptions, $configurationOptions);
		$widgetOptions['name'] = $name;
		$widgetOptions['value'] = $value;
		$widgetOptions['htmlOptions'] = $htmlOptions;

		return self::widget(self::getWidgetPath(self::INPUT_TYPEAHEAD), $widgetOptions);
	}

	/**
	 * @param CActiveRecord $model
	 * @param string $attribute
	 * @param array $htmlOptions additional attributes of the HTML element. Special attributes are supported.
	 * @see YiiStrap.TbTypeAhead for information about the special attributes.
	 * @return string
	 */
	public static function activeTypeAheadField($model, $attribute, $htmlOptions = array())
	{
		$configurationOptions = array('source', 'items', 'matcher', 'sorter', 'updater', 'minLength', 'highlighter');
		$widgetOptions = self::moveOptions(
			$configurationOptions,
			$htmlOptions,
			array());
		$htmlOptions = self::removeOptions($htmlOptions, $configurationOptions);
		$widgetOptions['model'] = $model;
		$widgetOptions['attribute'] = $attribute;
		$widgetOptions['htmlOptions'] = $htmlOptions;

		return self::widget(self::getWidgetPath(self::INPUT_TYPEAHEAD), $widgetOptions);
	}


	// Active Fields
	/**
	 * Renders and activeDatePickerField
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public static function activeDatePickerField($model, $attribute, $htmlOptions = array())
	{

		$widgetOptions = array('model' => $model, 'attribute' => $attribute, 'htmlOptions' => $htmlOptions);

		return self::widget(self::getWidgetPath(self::INPUT_DATEPICKER), $widgetOptions);
	}

	/**
	 * Gets a specific widget path
	 * @param $widget
	 * @return null
	 */
	public static function getWidgetPath($widget)
	{
		return array_key_exists($widget, self::$validInputs) ? self::$validInputs[$widget] : null;
	}

	/**
	 * Renders a widget
	 * @param $widget
	 * @param array $widgetOptions
	 * @return string
	 */
	public static function widget($widget, $widgetOptions = array())
	{
		ob_start();
		Yii::app()->getController()->widget($widget, $widgetOptions);
		return ob_get_clean();
	}
}