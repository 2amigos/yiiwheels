<?php
/**
 * WhDatePicker widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets
 * @uses YiiWheels.helpers.WhHtml
 */
Yii::import('yiiwheels.helpers.WhHtml');

class WhDatePicker extends CInputWidget
{
	/**
	 * @var array the options for the Bootstrap JavaScript plugin.
	 */
	public $pluginOptions = array();

	/**
	 * @var string[] the JavaScript event handlers.
	 */
	public $events = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$this->attachBehavior('ywplugin', array('class'=>'yiiwheels.behaviors.WhPlugin'));

		$this->htmlOptions = WhHtml::defaultOption('autocomplete', 'off', $this->htmlOptions);
		$this->htmlOptions = WhHtml::addClassName('grd-white', $this->htmlOptions);

		$this->initOptions();
	}

	/**
	 * Initializes options
	 */
	public function initOptions()
	{
		$this->pluginOptions = WhHtml::defaultOption('format', 'mm/dd/yyyy', $this->pluginOptions);
		$this->pluginOptions = WhHtml::defaultOption('autoclose', true, $this->pluginOptions);
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
	 * Renders field
	 */
	public function renderField()
	{
		list($name, $id) = $this->resolveNameID();

		$this->htmlOptions = WhHtml::defaultOption('id', $id, $this->htmlOptions);
		$this->htmlOptions = WhHtml::defaultOption('name', $name, $this->htmlOptions);

		if ($this->hasModel())
		{
			echo WhHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);

		} else
			echo WhHtml::textField($name, $this->value, $this->htmlOptions);
	}

	/**
	 * Registers required client script for bootstrap datepicker.
	 */
	public function registerClientScript()
	{
		/* publish assets dir */
		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$assetsUrl = $this->getAssetsUrl($path);

		/* @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();

		$cs->registerCssFile($assetsUrl . '/css/datepicker.css');
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-datepicker.js');

		if ($language = WhHtml::getOption('language', $this->pluginOptions))
		{
			$cs->registerScriptFile($assetsUrl . '/js/locales/bootstrap-datepicker.' . $language . '.js', CClientScript::POS_END);
		}

		/* initialize plugin */
		$selector = '#' . WhHtml::getOption('id', $this->htmlOptions, $this->getId());

		$this->getApi()->registerPlugin('datepicker', $selector, $this->pluginOptions);
		$this->getApi()->registerEvents($selector, $this->events);

	}
}