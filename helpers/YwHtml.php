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
	const INPUT_TIMEPICKER = 'timePickerField';
	const INPUT_SELECT2 = 'select2Field';
	const INPUT_TYPEAHEAD = 'typeAheadField';

	static $validInputs = array(
		self::INPUT_DATEPICKER => 'yiiwheels.widgets.datepicker.YwDatePicker',
		self::INPUT_TIMEPICKER => 'yiiwheels.widgets.timepicker.YwTimePicker',
		self::INPUT_SELECT2 => 'yiiwheels.widgets.select2.YwSelect2',
		self::INPUT_TYPEAHEAD => 'bootstrap.widgets.TbTypeAhead'
	);

	static $configurationOptions = array(
		self::INPUT_DATEPICKER => array('pluginOptions', 'events'),
		self::INPUT_TIMEPICKER => array('pluginOptions', 'events'),
		self::INPUT_TYPEAHEAD => array('source', 'items', 'matcher', 'sorter', 'updater', 'minLength', 'highlighter'),
		self::INPUT_SELECT2 => array('pluginOptions', 'events', 'asDropDownList', 'language', 'data')
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
		$defaultOptions = array('name' => $name, 'value' => $value);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_DATEPICKER, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_DATEPICKER), $widgetOptions);
	}

	/**
	 * Renders a timepicker field
	 * @param $name
	 * @param string $value
	 * @param array $htmlOptions
	 * @return string
	 */
	public static function timePickerField($name, $value = '', $htmlOptions = array())
	{
		$defaultOptions = array('name' => $name, 'value' => $value);

		$htmlOptions = self::addClassName('bootstrap-timepicker', $htmlOptions);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_TIMEPICKER, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_TIMEPICKER), $widgetOptions);
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
		$defaultOptions = array('name' => $name, 'value' => $value);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_TYPEAHEAD, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_TYPEAHEAD), $widgetOptions);
	}

	/**
	 * Renders a select2 field
	 * @param $name
	 * @param string $value
	 * @param array $htmlOptions
	 * @return string
	 */
	public static function select2Field($name, $value = '', $htmlOptions = array())
	{
		$defaultOptions = array('name' => $name, 'value' => $value);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_SELECT2, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_SELECT2), $widgetOptions);
	}

	// Active Fields
	/**
	 * Renders an active datepicker field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public static function activeDatePickerField($model, $attribute, $htmlOptions = array())
	{
		$defaultOptions = array('model' => $model, 'attribute' => $attribute);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_DATEPICKER, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_DATEPICKER), $widgetOptions);
	}

	/**
	 * Renders an activeTimePickerField
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public static function activeTimePickerField($model, $attribute, $htmlOptions = array())
	{
		$defaultOptions = array('model' => $model, 'attribute' => $attribute);

		$htmlOptions = self::addClassName('bootstrap-timepicker', $htmlOptions);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_TIMEPICKER, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_TIMEPICKER), $widgetOptions);
	}

	/**
	 * Renders and active typeahead field
	 * @param CActiveRecord $model
	 * @param string $attribute
	 * @param array $htmlOptions additional attributes of the HTML element. Special attributes are supported.
	 * @see YiiStrap.TbTypeAhead for information about the special attributes.
	 * @return string
	 */
	public static function activeTypeAheadField($model, $attribute, $htmlOptions = array())
	{
		$defaultOptions = array('model' => $model, 'attribute' => $attribute);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_TYPEAHEAD, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_TYPEAHEAD), $widgetOptions);
	}

	/**
	 * Renders an active select2
	 * @param CActiveRecord $model
	 * @param string $attribute
	 * @param array $htmlOptions additional attributes of the HTML element. Special attributes are supported.
	 * @see YiiStrap.TbTypeAhead for information about the special attributes.
	 * @return string
	 */
	public static function activeSelect2Field($model, $attribute, $htmlOptions = array())
	{
		$defaultOptions = array('model' => $model, 'attribute' => $attribute);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_SELECT2, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_SELECT2), $widgetOptions);
	}

	// Utility methods
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

	/**
	 * Extracts widget configuration options from array of htmlOptions
	 * @param string $widget the widget name
	 * @param array $htmlOptions additional HTML options
	 * @param array $options the default widget options
	 * @return array
	 */
	protected static function getWidgetConfigurationOptions($widget, $htmlOptions, $options = array())
	{
		$configurationOptions = self::$configurationOptions[$widget];

		$options = self::moveOptions(
			$configurationOptions,
			$htmlOptions,
			$options);

		$options['htmlOptions'] = self::removeOptions($htmlOptions, $configurationOptions);

		return $options;
	}
}