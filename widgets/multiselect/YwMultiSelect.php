<?php
/**
 * YwMultiSelect widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets
 * @uses YiiStrap.YwHtml
 */

class YwMultiSelect extends CInputWidget
{

	/**
	 * @var array @param data for generating the list options (value=>display)
	 */
	public $data = array();

	/**
	 * @var string[] the JavaScript event handlers.
	 */
	public $events = array();

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
		if(empty($this->data) && $this->asDropDownList === true)
			throw new CException(Yii::t('zii', '"data" attribute cannot be blank'));

		$this->attachBehavior('ywplugin', array('class'=>'yiiwheels.behaviors.YwPlugin'));
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

		$this->htmlOptions = YwHtml::defaultOption('id', $id, $this->htmlOptions);
		$this->htmlOptions = YwHtml::defaultOption('name', $name, $this->htmlOptions);

		if ($this->hasModel())
		{
			echo YwHtml::activeDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);

		} else
			echo YwHtml::dropDownList($this->name, $this->value, $this->data, $this->htmlOptions);
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

		$cs->registerCssFile($assetsUrl . '/css/bootstrap-multiselect.css');
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-multiselect.js');

		/* initialize plugin */
		$selector = '#' . YwHtml::getOption('id', $this->htmlOptions, $this->getId());

		$this->getApi()->registerPlugin('multiselect', $selector, $this->pluginOptions);
		$this->getApi()->registerEvents($selector, $this->events);
	}
}