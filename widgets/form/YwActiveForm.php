<?php
/**
 * YwTimePicker widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets
 * @uses YiiStrap.widgets.TbActiveForm
 * @uses YiiWheels.helpers.YwHtml
 */

Yii::import('bootstrap.widgets.TbActiveForm');
Yii::import('yiiwheels.helpers.YwHtml');

class YwActiveForm extends TbActiveForm
{
	/**
	 * Renders a datepicker field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function datePickerField($model, $attribute, $htmlOptions = array())
	{
		return $this->row(YwHtml::INPUT_DATEPICKER, $model, $attribute, array(), $htmlOptions);
	}

	/**
	 * Renders a timepicker field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function timePickerField($model, $attribute, $htmlOptions = array())
	{
		return $this->row(YwHtml::INPUT_TIMEPICKER, $model, $attribute, array(), $htmlOptions);
	}

	/**
	 * Renders a typeahead field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function typeAheadField($model, $attribute, $htmlOptions = array())
	{
		return $this->row(YwHtml::INPUT_TYPEAHEAD, $model, $attribute, array(), $htmlOptions);
	}

	/**
	 * Renders a typeahead field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function select2Field($model, $attribute, $htmlOptions = array())
	{
		return $this->row(YwHtml::INPUT_SELECT2, $model, $attribute, array(), $htmlOptions);
	}


	/**
	 * Helper method to display different input types for the different complain bootstrap forms wrapped with their
	 * labels, help and error messages. This method is a replacement of the old 'typeRow' methods from Yii-Bootstrap
	 * extension. Example:
	 * <pre>
	 *     $form->row(YwHtml::INPUT_TEXT, $model, 'attribute', array('style'=>'width:125px'));
	 *    $form->row(YwHtml::INPUT_DROPDOWN, $model, 'attribute', array('a'=>'A','b'=>'B'), array());
	 * </pre>
	 * @param $type
	 * @param $model
	 * @param $attribute
	 * @param $data
	 * @param array $htmlOptions
	 * @return string
	 * @throws CException
	 */
	public function row($type, $model, $attribute, $data = array(), $htmlOptions = array())
	{
		if (!in_array($type, YwHtml::validInputs()))
			throw new CException(Yii::t('tb', 'Unrecognized input type'));

		$labelOptions = YwHtml::popOption('labelOptions', $htmlOptions, array());
		$errorOptions = YwHtml::popOption('errorOptions', $htmlOptions, array());
		$containerOptions = YwHtml::popOption('containerOptions', $htmlOptions, array());

		$labelOptions = YwHtml::defaultOption('formType', $this->type, $labelOptions);

		ob_start();

		// make sure it holds the class control-label
		if ($this->type === YwHtml::FORM_HORIZONTAL)
			echo CHtml::openTag('div', YwHtml::addClassName('control-group', $containerOptions));

		// form's inline do not render labels and radio|checkbox input types render label's differently
		if ($this->type !== YwHtml::FORM_INLINE
			&& !preg_match('/radio|checkbox/i', $type)
			&& YwHtml::popOption('label', $htmlOptions, true)
		)
			echo YwHtml::activeLabel($model, $attribute, $labelOptions);
		elseif (preg_match('/radio|checkbox/i', $type))
			$htmlOptions['labelOptions'] = $labelOptions;

		if (YwHtml::popOption('block', $htmlOptions, false))
			$htmlOptions = YwHtml::addClassName('input-block-level', $htmlOptions);

		$params = in_array($type, YwHtml::$dataInputs)
			? array($model, $attribute, $data, $htmlOptions)
			: array($model, $attribute, $htmlOptions);

		$errorSpan = $this->error($model, $attribute, $errorOptions);

		echo $this->wrapControl(call_user_func_array('YwHtml::active' . ucfirst($type), $params), $errorSpan); /* since PHP 5.3 */

		if ($this->type == YwHtml::FORM_VERTICAL && YwHtml::popOption('error', $htmlOptions, true))
			echo $errorSpan;

		if ($this->type == YwHtml::FORM_HORIZONTAL)
			echo '</div>';

		return ob_get_clean();

	}
}