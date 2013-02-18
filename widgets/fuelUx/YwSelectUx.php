<?php
/**
 * YwSelectUx widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets
 * @uses YiiStrap.YwHtml
 */

class YwSelectUx extends CInputWidget
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
	 * @var bool whether to display a dropdown select box or use it for tagging
	 */
	public $asDropDownList = true;

	/**
	 * @var string locale. Defaults to null. Possible values: "it"
	 */
	public $language;

	/**
	 * @var array the plugin options
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
	 * Renders the select2 field
	 */
	public function renderField()
	{
		list($name, $id) = $this->resolveNameID();

		$this->htmlOptions = YwHtml::defaultOption('id', $id, $this->htmlOptions);
		$this->htmlOptions = YwHtml::defaultOption('name', $name, $this->htmlOptions);

		if ($this->hasModel())
		{
			echo $this->asDropDownList?
				YwHtml::activeDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions) :
				YwHtml::activeHiddenField($this->model, $this->attribute);

		} else
			echo $this->asDropDownList ?
				YwHtml::dropDownList($this->name, $this->value, $this->data, $this->htmlOptions) :
				YwHtml::hiddenField($this->name, $this->value);
	}
	/**
	 * Registers required client script for bootstrap select2. It is not used through bootstrap->registerPlugin
	 * in order to attach events if any
	 */
	public function registerClientScript()
	{
		/* publish assets dir */
		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$assetsUrl = $this->getAssetsUrl($path);

		/* @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();

		$cs->registerCssFile($assetsUrl . '/css/select2.css');
		$cs->registerScriptFile($assetsUrl . '/js/select2.js');


		if ($this->language)
		{
			$cs->registerScriptFile($assetsUrl . '/js/locale/select2_locale_' . $this->language . '.js', CClientScript::POS_END);
		}

		/* initialize plugin */
		$selector = '#' . YwHtml::getOption('id', $this->htmlOptions, $this->getId());

		$this->getApi()->registerPlugin('select2', $selector, $this->pluginOptions);
		$this->getApi()->registerEvents($selector, $this->events);
	}
}