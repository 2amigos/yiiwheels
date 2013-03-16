<?php
/**
* WhMaskMoney widget class
*
* @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets
 * @uses YiiWheels.WhHtml
 */

Yii::import('yiiwheels.helpers.WhHtml');

class WhMaskMoney extends CInputWidget
{

	/**
	 * @var array the plugin options
	 * @see http://davidstutz.github.com/bootstrap-multiselect/
	 */
	public $pluginOptions;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$this->attachBehavior('ywplugin', array('class'=>'yiiwheels.behaviors.WhPlugin'));
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
	 * Renders the multiselect field
	 */
	public function renderField()
	{
		list($name, $id) = $this->resolveNameID();

		$this->htmlOptions = WhHtml::defaultOption('id', $id, $this->htmlOptions);
		$this->htmlOptions = WhHtml::defaultOption('name', $name, $this->htmlOptions);

		if ($this->hasModel())
			echo WhHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
		else
			echo WhHtml::textField($this->name, $this->value, $this->htmlOptions);
	}

	/**
	 * Registers required client script for bootstrap multiselect. It is not used through bootstrap->registerPlugin
	 * in order to attach events if any
	 */
	public function registerClientScript()
	{
		/* publish assets dir */
		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$assetsUrl = $this->getAssetsUrl($path);

		/* @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();

		$cs->registerScriptFile($assetsUrl . '/js/jquery.maskmoney.js');

		/* initialize plugin */
		$selector = '#' . WhHtml::getOption('id', $this->htmlOptions, $this->getId());

		$this->getApi()->registerPlugin('maskMoney', $selector, $this->pluginOptions);
	}
}