<?php
/**
 * WhHtml class file.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; Antonio Ramirez 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package yiiwheels.helpers
 */
class WhHtml extends TbHtml
{
	const INPUT_DATEPICKER = 'datePickerRow';
	const INPUT_TIMEPICKER = 'timePickerRow';
	const INPUT_SELECT2 = 'select2Row';
	const INPUT_TYPEAHEAD = 'typeAheadRow';
	const INPUT_MULTISELECT = 'multiSelectRow';

	static $validInputs = array(
		self::INPUT_TYPEAHEAD => 'bootstrap.widgets.TbTypeAhead',
		self::INPUT_DATEPICKER => 'yiiwheels.widgets.datepicker.WhDatePicker',
		self::INPUT_TIMEPICKER => 'yiiwheels.widgets.timepicker.WhTimePicker',
		self::INPUT_SELECT2 => 'yiiwheels.widgets.select2.WhSelect2',
		self::INPUT_MULTISELECT => 'yiiwheels.widgets.multiselect.WhMultiSelect'
	);

	static $configurationOptions = array(
		self::INPUT_DATEPICKER => array('pluginOptions', 'events'),
		self::INPUT_TIMEPICKER => array('pluginOptions', 'events'),
		self::INPUT_TYPEAHEAD => array('source', 'items', 'matcher', 'sorter', 'updater', 'minLength', 'highlighter'),
		self::INPUT_SELECT2 => array('pluginOptions', 'events', 'asDropDownList', 'language', 'data'),
		self::INPUT_MULTISELECT => array('pluginOptions', 'events', 'data')
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
	public static function datePickerRow($name, $value = '', $htmlOptions = array())
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
	public static function timePickerRow($name, $value = '', $htmlOptions = array())
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
	public static function typeAheadRow($name, $value = '', $htmlOptions = array())
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
	public static function select2Row($name, $value = '', $htmlOptions = array())
	{
		$defaultOptions = array('name' => $name, 'value' => $value);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_SELECT2, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_SELECT2), $widgetOptions);
	}

	/**
	 * Renders a multiselect field
	 * @param $name
	 * @param string $value
	 * @param array $htmlOptions
	 * @return string
	 */
	public static function multiSelectRow($name, $value = '', $htmlOptions = array())
	{
		$defaultOptions = array('name' => $name, 'value' => $value);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_MULTISELECT, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_MULTISELECT), $widgetOptions);
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

	/**
	 * Renders an active multi select field
	 * @param CActiveRecord $model
	 * @param string $attribute
	 * @param array $htmlOptions additional attributes of the HTML element. Special attributes are supported.
	 * @see YiiStrap.TbTypeAhead for information about the special attributes.
	 * @return string
	 */
	public static function activeMultiSelectField($model, $attribute, $htmlOptions = array())
	{
		$defaultOptions = array('model' => $model, 'attribute' => $attribute);

		$widgetOptions = self::getWidgetConfigurationOptions(self::INPUT_MULTISELECT, $htmlOptions, $defaultOptions);

		return self::widget(self::getWidgetPath(self::INPUT_MULTISELECT), $widgetOptions);
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