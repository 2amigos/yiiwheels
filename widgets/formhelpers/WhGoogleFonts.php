<?php
/**
 * WhGoogleFonts widget class
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

class WhGoogleFonts extends CInputWidget
{
	/**
	 * Editor options that will be passed to the editor.
	 *
	 * - family
	 * - subsets
	 * - families
	 * @see http://vincentlamanna.com/BootstrapFormHelpers/googlefont.html
	 */
	public $pluginOptions = array();

	/**
	 * @var bool whether to use bootstrap helper select Box widget
	 */
	public $useHelperSelectBox = false;

	/**
	 * @var array extra config options for helper select box
	 */
	public $helperOptions = array();


	/**
	 * Widget's initialization method
	 * @throws CException
	 */
	public function init()
	{

		$this->attachBehavior('ywplugin', array('class' => 'yiiwheels.behaviors.WhPlugin'));

		TbHtml::addCssClass('bfh-googlefonts', $this->htmlOptions);
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

		if ($this->useHelperSelectBox) {
			$select = Yii::createComponent(CMap::mergeArray($this->helperOptions, array(
				'class' => 'yiiwheels.widgets.formhelpers.WhSelectBox',
				'htmlOptions' => $this->htmlOptions,
				'model' => $this->model,
				'attribute' => $this->attribute,
				'name' => $this->name,
				'value' => $this->value,
				'wrapperOptions' => array(
					'class' => 'bfh-googlefonts',
					'data-family' => $this->hasModel() ? $this->model->{$this->attribute} : $this->value,
					'data-subsets' => isset($this->pluginOptions['subsets'])
						? $this->pluginOptions['subsets']
						: null,
					'data-families' => isset($this->pluginOptions['families'])
						? $this->pluginOptions['families']
						: null
				)
			)));
			$select->init();
			$select->run();
		} else {
			$this->htmlOptions['data-family'] = $this->hasModel()
				? $this->model->{$this->attribute}
				: $this->value;
			$this->htmlOptions['data-subsets'] = isset($this->pluginOptions['subsets'])
				? $this->pluginOptions['subsets']
				: null;
			$this->htmlOptions['data-families'] = isset($this->pluginOptions['families'])
				? $this->pluginOptions['families']
				: null;
			if ($this->hasModel()) {
				echo CHtml::activeDropDownList($this->model, $this->attribute, array(), $this->htmlOptions);
			} else {
				echo CHtml::dropDownList($name, $this->value, array(), $this->htmlOptions);
			}
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

		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-formhelpers-googlefonts.codes.js');
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-formhelpers-googlefonts.js');

		/* initialize plugin */
		if (!$this->useHelperSelectBox) {
			$selector = '#' . TbArray::getValue('id', $this->htmlOptions, $this->getId());
			$this->getApi()->registerPlugin('bfhgooglefonts', $selector, $this->pluginOptions);
		}
	}
}