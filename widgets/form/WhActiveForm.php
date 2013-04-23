<?php
/**
 * WhTimePicker widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets
 * @uses YiiStrap.widgets.TbActiveForm
 * @uses YiiWheels.helpers.WhHtml
 */

Yii::import('bootstrap.widgets.TbActiveForm');
Yii::import('yiiwheels.helpers.WhHtml');

class WhActiveForm extends TbActiveForm
{
	/**
	 * Renders a datepicker field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function datePickerRow($model, $attribute, $htmlOptions = array())
	{
		return $this->row(WhHtml::INPUT_DATEPICKER, $model, $attribute, array(), $htmlOptions);
	}

	/**
	 * Renders a timepicker field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function timePickerRow($model, $attribute, $htmlOptions = array())
	{
		return $this->row(WhHtml::INPUT_TIMEPICKER, $model, $attribute, array(), $htmlOptions);
	}

	/**
	 * Renders a typeahead field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function typeAheadRow($model, $attribute, $htmlOptions = array())
	{
		return $this->row(WhHtml::INPUT_TYPEAHEAD, $model, $attribute, array(), $htmlOptions);
	}

	/**
	 * Renders a typeahead field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function select2Row($model, $attribute, $htmlOptions = array())
	{
		return $this->row(WhHtml::INPUT_SELECT2, $model, $attribute, array(), $htmlOptions);
	}

	/**
	 * Renders a multiselect field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function multiSelectRow($model, $attribute, $htmlOptions = array())
	{
		return $this->row(WhHtml::INPUT_MULTISELECT, $model, $attribute, array(), $htmlOptions);
	}

	/**
	 * Renders a maskmoney field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function maskMoneyRow($model, $attribute, $htmlOptions = array())
	{
		return $this->row(WhHtml::INPUT_MASKMONEY, $model, $attribute, array(), $htmlOptions);
	}

	/**
	 * Renders a redactor wyiwyg field
	 * @param $model
	 * @param $attribute
	 * @param array $htmlOptions
	 * @return string
	 */
	public function redactorJsRow($model, $attribute, $htmlOptions = array())
	{
		return $this->row(WhHtml::INPUT_REDACTOR, $model, $attribute, $htmlOptions);
	}

	/**
	 * Helper method to display different input types for the different complain bootstrap forms wrapped with their
	 * labels, help and error messages. This method is a replacement of the old 'typeRow' methods from Yii-Bootstrap
	 * extension. Example:
	 * <pre>
	 *     $form->row(WhHtml::INPUT_TEXT, $model, 'attribute', array('style'=>'width:125px'));
	 *    $form->row(WhHtml::INPUT_DROPDOWN, $model, 'attribute', array('a'=>'A','b'=>'B'), array());
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
		if (!in_array($type, WhHtml::validInputs()))
			throw new CException(Yii::t('tb', 'Unrecognized input type'));

		$labelOptions = WhHtml::popOption('labelOptions', $htmlOptions, array());
		$errorOptions = WhHtml::popOption('errorOptions', $htmlOptions, array());
		$containerOptions = WhHtml::popOption('containerOptions', $htmlOptions, array());

		$labelOptions = WhHtml::defaultOption('formType', $this->type, $labelOptions);

		ob_start();

		// make sure it holds the class control-label
		if ($this->type === WhHtml::FORM_HORIZONTAL)
			echo CHtml::openTag('div', WhHtml::addClassName('control-group', $containerOptions));

		// form's inline do not render labels and radio|checkbox input types render label's differently
		if ($this->type !== WhHtml::FORM_INLINE
			&& !preg_match('/radio|checkbox/i', $type)
			&& WhHtml::popOption('label', $htmlOptions, true)
		)
			echo CHtml::activeLabel($model, $attribute, $labelOptions);
		elseif (preg_match('/radio|checkbox/i', $type))
			$htmlOptions['labelOptions'] = $labelOptions;

		if (WhHtml::popOption('block', $htmlOptions, false))
			$htmlOptions = WhHtml::addClassName('input-block-level', $htmlOptions);

		$params = in_array($type, WhHtml::$dataInputs)
			? array($model, $attribute, $data, $htmlOptions)
			: array($model, $attribute, $htmlOptions);

		$errorSpan = $this->error($model, $attribute, $errorOptions);

		echo $this->wrapControl(call_user_func_array('WhHtml::active' . ucfirst($type), $params), $errorSpan); /* since PHP 5.3 */

		if ($this->type == WhHtml::FORM_VERTICAL && WhHtml::popOption('error', $htmlOptions, true))
			echo $errorSpan;

		if ($this->type == WhHtml::FORM_HORIZONTAL)
			echo '</div>';

		return ob_get_clean();

	}
}