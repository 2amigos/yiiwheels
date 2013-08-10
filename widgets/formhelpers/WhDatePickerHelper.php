<?php
/**
 * WhDatePicker widget class
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

class WhDatePickerHelper extends CInputWidget
{

	/**
	 * @var string the formatting options
	 */
	public $format = 'y-m-d';

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

		TbHtml::addCssClass('bfh-datepicker', $this->htmlOptions);
		$this->htmlOptions['data-format'] = $this->format;
		$this->htmlOptions['data-date'] = $this->hasModel()
			? $this->model->{$this->attribute}
			: $this->value;

		$this->inputOptions['readonly'] = true;
		$this->pluginOptions['format'] = $this->format;
		$this->pluginOptions['date'] = $this->htmlOptions['data-date'];

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
			'class' => 'input-prepend bfh-datepicker-toggle',
			'data-toggle' => 'bfh-datepicker'
		));
		echo CHtml::tag('span', array('class' => 'add-on'), TbHtml::icon(TbHtml::ICON_CALENDAR));
		if ($this->hasModel()) {
			echo CHtml::activeTextField($this->model, $this->attribute, $this->inputOptions);
		} else {
			echo CHtml::textField($name, $this->value, $this->inputOptions);
		}
		echo CHtml::closeTag('div');

		echo '<div class="bfh-datepicker-calendar">
				<table class="calendar table table-bordered">
					<thead>
						<tr class="months-header">
							<th class="month" colspan="4">
							<a class="previous" href="#"><i class="icon-chevron-left"></i></a>
							<span></span>
							<a class="next" href="#"><i class="icon-chevron-right"></i></a>
						</th>
						<th class="year" colspan="3">
							<a class="previous" href="#"><i class="icon-chevron-left"></i></a>
							<span></span>
							<a class="next" href="#"><i class="icon-chevron-right"></i></a>
						</th>
						</tr>
						<tr class="days-header">
						</tr>
					</thead>
					<tbody>
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
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-formhelpers-datepicker.en_US.js');
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-formhelpers-datepicker.js');

		/* initialize plugin */
		// $selector = '#' . TbArray::getValue('id', $this->htmlOptions, $this->getId());
		// $this->getApi()->registerPlugin('bfhdatepicker', $selector, $this->pluginOptions);

	}
}