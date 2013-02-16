<?php
/**
 * YwDatePicker widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets
 * @uses YiiStrap.YwHtml
 */
Yii::import('yiiwheels.behaviors.YwPlugin');

class YwDatePicker extends CInputWidget
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
		$this->attachBehavior('ywplugin', new YwPlugin());

		$this->htmlOptions = YwHtml::defaultOption('autocomplete', 'off', $this->htmlOptions);
		$this->htmlOptions = YwHtml::addClassName('grd-white', $this->htmlOptions);

		$this->initOptions();
	}

	/**
	 * Initializes options
	 */
	public function initOptions()
	{
		$this->pluginOptions = YwHtml::defaultOption('format', 'mm/dd/yyyy', $this->pluginOptions);
		$this->pluginOptions = YwHtml::defaultOption('autoclose', true, $this->pluginOptions);
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

		$this->htmlOptions = YwHtml::defaultOption('id', $id, $this->htmlOptions);
		$this->htmlOptions = YwHtml::defaultOption('name', $name, $this->htmlOptions);

		if ($this->hasModel())
		{
			echo YwHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);

		} else
			echo YwHtml::textField($name, $this->value, $this->htmlOptions);
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

		if ($language = YwHtml::getOption('language', $this->pluginOptions))
		{
			$cs->registerScriptFile($assetsUrl . '/js/locales/bootstrap-datepicker.' . $language . '.js', CClientScript::POS_END);
		}

		/* initialize plugin */
		$selector = '#' . YwHtml::getOption('id', $this->htmlOptions, $this->getId());

		$this->getApi()->registerPlugin('datepicker', $selector, $this->pluginOptions);
		$this->getApi()->registerEvents($selector, $this->events);

	}
}