<?php
/**
 * WhTypeAhead widget class
 *
 * @see https://github.com/twitter/typeahead.js
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets
 * @uses YiiWheels.WhHtml
 */
Yii::import('yiiwheels.helpers.WhHtml');

class WhTypeAhead extends CInputWidget
{

	/**
	 * @var array the plugin options
	 * @see https://github.com/twitter/typeahead.js
	 */
	public $pluginOptions;

	/**
	 * @var bool whether to display minified versions of the files or not
	 */
	public $debugMode = false;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		if (empty($this->data) && $this->asDropDownList === true)
			throw new CException(Yii::t('zii', '"data" attribute cannot be blank'));

		$this->attachBehavior('ywplugin', array('class' => 'yiiwheels.behaviors.WhPlugin'));
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
	 * Renders the typeahead field
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
	 * Registers required client script for bootstrap typeahead. It is not used through bootstrap->registerPlugin
	 * in order to attach events if any
	 */
	public function registerClientScript()
	{
		/* publish assets dir */
		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$assetsUrl = $this->getAssetsUrl($path);

		/* @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();

		$min = $this->debugMode
			? '.min'
			: '';

		$cs->registerCssFile($assetsUrl . '/css/typeahead' . $min . '.css');
		$cs->registerScriptFile($assetsUrl . '/js/typeahead' . $min . '.js');

		/* initialize plugin */
		$selector = '#' . WhHtml::getOption('id', $this->htmlOptions, $this->getId());

		$this->getApi()->registerPlugin('typeahead', $selector, $this->pluginOptions);
	}
}