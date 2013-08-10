<?php
/**
 * WhTimePickerHelper widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets.formhelpers
 * @uses YiiStrap.helpers.TbArray
 * @uses YiiStrap.helpers.TbHtml
 */
Yii::import('bootstrap.helpers.TbArray');
Yii::import('bootstrap.helpers.TbHtml');

class WhTimePickerHelper extends CInputWidget
{

	/**
	 * @var array options of the input
	 */
	public $inputOptions = array();

	/**
	 * @var array
	 */
	public $pluginOptions = array();


	/**
	 * Widget's initialization method
	 * @throws CException
	 */
	public function init()
	{

		$this->attachBehavior('ywplugin', array('class' => 'yiiwheels.behaviors.WhPlugin'));

		TbHtml::addCssClass('bfh-timepicker', $this->htmlOptions);
		$this->htmlOptions['data-time'] = $this->hasModel()
			? $this->model->{$this->attribute}
			: $this->value;

		$this->inputOptions['readonly'] = true;
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$this->renderField();
		$this->registerClientScript();
	}

	/**
	 * Renders the input file field
	 */
	public function renderField()
	{

		list($name, $id) = $this->resolveNameID();

		TbArray::defaultValue('id', $id, $this->htmlOptions);
		TbArray::defaultValue('name', $name, $this->htmlOptions);

		echo CHtml::openTag('div', $this->htmlOptions);
		echo CHtml::openTag('div', array(
			'class' => 'input-prepend bfh-timepicker-toggle',
			'data-toggle' => 'bfh-timepicker'
		));
		echo CHtml::tag('span', array('class' => 'add-on'), TbHtml::icon(TbHtml::ICON_TIME));
		if ($this->hasModel()) {
			echo CHtml::activeTextField($this->model, $this->attribute, $this->inputOptions);
		} else {
			echo CHtml::textField($name, $this->value, $this->inputOptions);
		}
		echo CHtml::closeTag('div');

		echo '<div class="bfh-timepicker-popover">
				<table class="table">
				<tbody>
					<tr>
						<td class="hour">
						<a class="next" href="#"><i class="icon-chevron-up"></i></a><br>
						<input type="text" class="input-mini" readonly><br>
						<a class="previous" href="#"><i class="icon-chevron-down"></i></a>
						</td>
						<td class="separator">:</td>
						<td class="minute">
						<a class="next" href="#"><i class="icon-chevron-up"></i></a><br>
						<input type="text" class="input-mini" readonly><br>
						<a class="previous" href="#"><i class="icon-chevron-down"></i></a>
						</td>
					</tr>
				</tbody>
				</table>
			</div>';
		echo CHtml::closeTag('div');
	}

	/**
	 * Registers client script
	 */
	public function registerClientScript()
	{
		/* publish assets dir */
		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$assetsUrl = $this->getAssetsUrl($path);

		/* @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();

		$cs->registerCssFile($assetsUrl . '/css/bootstrap-formhelpers.css');
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-formhelpers-timepicker.js');

		/* initialize plugin */
		// $selector = '#' . TbArray::getValue('id', $this->htmlOptions, $this->getId());
		// $this->getApi()->registerPlugin('bfhdatepicker', $selector, $this->pluginOptions);

	}
}