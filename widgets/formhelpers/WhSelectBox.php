<?php
/**
 * WhSelectBox widget class
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

class WhSelectBox extends CInputWidget
{

	/**
	 * @var array the data list to display
	 */
	public $data = array();

	/**
	 * @var string size. Valid values are:
	 *
	 * - input-mini
	 * - input-small
	 * - input-medium
	 * - input-large
	 * - input-xlarge
	 * - input-xxlarge
	 */
	public $size = 'input-medium';

	/**
	 * @var bool whether to display filter or not
	 */
	public $displayFilter = true;

	/**
	 * @var array the htmlOptions of the wrapper layer
	 */
	public $wrapperOptions = array();

	/**
	 * Widget's initialization method
	 * @throws CException
	 */
	public function init()
	{
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
	 * Renders the input file field
	 */
	public function renderField()
	{
		list($name, $id) = $this->resolveNameID();

		TbArray::defaultValue('id', $id, $this->htmlOptions);
		TbArray::defaultValue('name', $name, $this->htmlOptions);

		TbHtml::addCssClass('bfh-selectbox', $this->wrapperOptions);
		echo CHtml::openTag('div', $this->wrapperOptions);
		if ($this->hasModel()) {
			echo CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
			$value = $this->model->{$this->attribute};
			$valueText = $value && isset($this->data[$value]) ? $this->data[$value] : '&nbsp;';
		} else {
			echo CHtml::hiddenField($name, $this->value, $this->htmlOptions);
			$value = $this->value;
			$valueText = $value && isset($this->data[$value]) ? $this->data[$value] : '&nbsp;';
		}

		echo CHtml::openTag('a', array('class' => 'bfh-selectbox-toggle', 'role' => 'button', 'data-toggle' => 'bfh-selectbox', 'href' => '#'));
			echo CHtml::tag('span', array('class' => 'bfh-selectbox-option ' . $this->size, 'data-option' => $value), $valueText);
			echo CHtml::tag('b', array('class' => 'caret'), '&nbsp;');
		echo CHtml::closeTag('a');

		echo CHtml::openTag('div', array('class' => 'bfh-selectbox-options'));
		if($this->displayFilter) {
			echo '<input type="text" class="bfh-selectbox-filter">';
		}
		$items = array();
		foreach($this->data as $key=>$item) {
			$items[] = CHtml::tag('a', array('tabindex' => '-1', 'href' => '#', 'data-option' => $key), $item);
		}
		echo CHtml::tag('ul', array('role'=>'options'), '<li>' . implode('</li><li>', $items) . '</i>');
		echo CHtml::closeTag('div');

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
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-formhelpers-selectbox.js');

	}
}