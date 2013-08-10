<?php
/**
 * WhPhone widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets.formhelpers
 * @uses YiiStrap.helpers.TbArray
 */
Yii::import('bootstrap.helpers.TbArray');

class WhPhone extends CInputWidget
{

	/**
	 * @var string the formatting options
	 */
	public $format = false;

	/**
	 * @var bool whether to display the language selection read only or not.
	 */
	public $readOnly = false;

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

		TbHtml::addCssClass('bfh-phone', $this->htmlOptions);
		$this->htmlOptions['data-format'] = $this->format;
		if ($this->readOnly) {
			$this->htmlOptions['data-number'] = $this->hasModel()
				? $this->model->{$this->attribute}
				: $this->value;
		} else {
			$this->pluginOptions['format'] = $this->format;
			$this->pluginOptions['value'] = $this->hasModel()
				? $this->model->{$this->attribute}
				: $this->value;
		}

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


		if (!$this->readOnly) {
			if ($this->hasModel()) {
				echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
			} else {
				echo CHtml::textField($name, $this->value, $this->htmlOptions);
			}
		} else {
			echo CHtml::tag('span', $this->htmlOptions);
		}
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
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-formhelpers-phone.js');

		/* initialize plugin */
		if(!$this->readOnly)
		{
			$selector = '#' . TbArray::getValue('id', $this->htmlOptions, $this->getId());
			$this->getApi()->registerPlugin('bfhphone', $selector, $this->pluginOptions);
		}
	}
}