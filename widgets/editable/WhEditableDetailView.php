<?php
/**
 * WhEditableColumn class
 *
 * Makes editable CDetailView (several attributes of single model shown as name-value table).
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets.editable
 *
 *
 * @author Vitaliy Potapov <noginsk@rambler.ru>
 * @link https://github.com/vitalets/x-editable-yii
 * @copyright Copyright &copy; Vitaliy Potapov 2012
 * @version 1.3.1
 */

Yii::import('yiiwheels.widgets.editable.WhEditableField');
Yii::import('zii.widgets.CDetailView');

class WhEditableDetailView extends CDetailView
{

	/**
	 * @var array  Data for default fields of WhEditableField
	 */
	private $_data = array();

	/**
	 * @var Valid attributes for WhEditableField (singleton)
	 */
	private $_editableProperties;


	/**
	 * Initializes the widget
	 * @throws CException
	 */
	public function init()
	{
		if (!$this->data instanceof CModel) {
			throw new CException('Property "data" should be of CModel class.');
		}


		$this->htmlOptions = array('class' => 'table table-bordered table-striped table-hover');
		//disable loading Yii's css for bootstrap
		$this->cssFile = false;


		parent::init();
	}

	/**
	 * Renders an item
	 * @param array $options
	 * @param string $templateData
	 */
	protected function renderItem($options, $templateData)
	{
		//apply editable if not set 'editable' params or set and not false
		$apply = !empty($options['name']) && (!isset($options['editable']) || $options['editable'] !== false);

		if ($apply) {
			//ensure $options['editable'] is array
			if (!isset($options['editable'])) $options['editable'] = array();

			//merge options with defaults: url, params, etc.
			$options['editable'] = CMap::mergeArray($this->_data, $options['editable']);

			//options to be passed into EditableField (constructed from $options['editable'])
			$widgetOptions = array(
				'model' => $this->data,
				'attribute' => $options['name']
			);

			//if value in detailview options provided, set text directly (as value here means text)
			if (isset($options['value']) && $options['value'] !== null) {
				$widgetOptions['text'] = $templateData['{value}'];
				$widgetOptions['encode'] = false;
			}

			$widgetOptions = CMap::mergeArray($widgetOptions, $options['editable']);

			$widget = $this->controller->createWidget('WhEditableField', $widgetOptions);

			//'apply' maybe changed during init of widget (e.g. if related model has unsafe attribute)
			if ($widget->apply) {
				ob_start();
				$widget->run();
				$templateData['{value}'] = ob_get_clean();
			}
		}

		parent::renderItem($options, $templateData);
	}

	/**
	 * Get the properties available for {@link EditableField}.
	 * These properties can also be set for the {@link WEditableDetailView} as default values.
	 */
	private function getEditableProperties()
	{
		if (!isset($this->_editableProperties)) {
			$reflection = new ReflectionClass('WhEditableField');
			$this->_editableProperties = array_map(function ($d) {
				return $d->getName();
			}, $reflection->getProperties());
		}
		return $this->_editableProperties;
	}

	/**
	 * (non-PHPdoc)
	 * @see CComponent::__get()
	 */
	public function __get($key)
	{
		return (array_key_exists($key, $this->_data) ? $this->_data[$key] : parent::__get($key));
	}

	/**
	 * (non-PHPdoc)
	 * @see CComponent::__set()
	 */
	public function __set($key, $value)
	{
		if (in_array($key, $this->getEditableProperties())) {
			$this->_data[$key] = $value;
		} else {
			parent::__set($key, $value);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see CComponent::__isset()
	 */
	public function __isset($name)
	{
		return array_key_exists($name, $this->_data) || parent::__isset($name);
	}
}
