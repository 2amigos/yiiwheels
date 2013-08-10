<?php
/**
 * WhEditable class
 *
 * Creates editable element on page (without linking to model attribute)
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets.editable
 *
 * @author Vitaliy Potapov <noginsk@rambler.ru>
 * @link https://github.com/vitalets/x-editable-yii
 * @copyright Copyright &copy; Vitaliy Potapov 2012
 * @version 1.3.1
 */
class WhEditable extends CWidget
{

	/**
	 * @var string type of editable widget. Can be `text`, `textarea`, `select`, `date`, `checklist`, etc.
	 * @see x-editable
	 */
	public $type = null;

	/**
	 * @var string url to submit value. Can be string or array containing Yii route, e.g. `array('site/updateUser')`
	 * @see x-editable
	 */
	public $url = null;

	/**
	 * @var mixed primary key
	 * @see x-editable
	 */
	public $pk = null;

	/**
	 * @var string name of field
	 * @see x-editable
	 */
	public $name = null;

	/**
	 * @var array additional params to send on server
	 * @see x-editable
	 */
	public $params = null;
	/**
	 * @var string css class of input. If `null` - default X-editable value is used: `input-medium`
	 * @see x-editable
	 */
	public $inputclass = null;

	/**
	 * @var string mode of input: `inline` | `popup`. If not set - default X-editable value is used: `popup`.
	 * @see x-editable
	 */
	public $mode = null;

	/**
	 * @var string text to be shown as element content
	 */
	public $text = null;

	/**
	 * @var mixed initial value. If not set - will be taken from text
	 * @see x-editable
	 */
	public $value = null;

	/**
	 * @var string placement of popup. Can be `left`, `top`, `right`, `bottom`. If `null` - default X-editable value is used: `top`
	 * @see x-editable
	 */
	public $placement = null;

	/**
	 * @var string text shown on empty field. If `null` - default X-editable value is used: `Empty`
	 * @see x-editable
	 */
	public $emptytext = null;

	/**
	 * @var string visibility of buttons. Can be boolean `false|true` or string `bottom`.
	 * @see x-editable
	 */
	public $showbuttons = null;

	/**
	 * @var string Strategy for sending data on server. Can be `auto|always|never`.
	 * When 'auto' data will be sent on server only if **pk** and **url** defined, otherwise new value will be stored locally.
	 * @see x-editable
	 */
	public $send = null;

	/**
	 * @var boolean will editable be initially disabled. It means editable plugin will be applied to element,
	 * but you should call `.editable('enable')` method to activate it.
	 * To totally disable applying 'editable' to element use **apply** option.
	 * @see x-editable
	 */
	public $disabled = false;

	//list
	/**
	 * @var mixed source data for **select**, **checklist**. Can be string (url) or array in format:
	 * array( array("value" => 1, "text" => "abc"), ...)
	 * @package list
	 * @see x-editable
	 */
	public $source = null;

	//date
	/**
	 * @var string format to send date on server. If `null` - default X-editable value is used: `yyyy-mm-dd`.
	 * @package date
	 * @see x-editable
	 */
	public $format = null;

	/**
	 * @var string format to display date in element. If `null` - equals to **format** option.
	 * @package date
	 * @see x-editable
	 */
	public $viewformat = null;

	/**
	 * @var string template for **combodate** input. For details see http://vitalets.github.com/x-editable/docs.html#combodate.
	 * @package combodate
	 * @see x-editable
	 */
	public $template = null;

	/**
	 * @var array full config for **combodate** input. For details see http://vitalets.github.com/combodate/#docs
	 * @package combodate
	 * @see x-editable
	 */
	public $combodate = null;

	/**
	 * @var string separator used to display tags.
	 * @package select2
	 * @see x-editable
	 */
	public $viewseparator = null;

	/**
	 * @var array full config for **select2** input. For details see http://ivaynberg.github.com/select2
	 * @package select2
	 * @see x-editable
	 */
	public $select2 = null;

	//methods
	/**
	 * A javascript function that will be invoked to validate value.
	 * Example:
	 * <pre>
	 * 'validate' => 'js: function(value) {
	 *     if($.trim(value) == "") return "This field is required";
	 * }'
	 * </pre>
	 *
	 * @var string
	 * @package callback
	 * @see x-editable
	 * @example
	 */
	public $validate = null;

	/**
	 * A javascript function that will be invoked to process successful server response.
	 * Example:
	 * <pre>
	 * 'success' => 'js: function(response, newValue) {
	 *     if(!response.success) return response.msg;
	 * }'
	 * </pre>
	 *
	 * @var string
	 * @package callback
	 * @see x-editable
	 */
	public $success = null;

	/**
	 * A javascript function that will be invoked to custom display value.
	 * Example:
	 * <pre>
	 * 'display' => 'js: function(value, sourceData) {
	 *      var escapedValue = $("&lt;div&gt;").text(value).html();
	 *      $(this).html("&lt;b&gt;"+escapedValue+"&lt;/b&gt;");
	 * }'
	 * </pre>
	 *
	 * @var string
	 * @package callback
	 * @see x-editable
	 */
	public $display = null;

	/**
	 * DOM id of target where afterAjaxUpdate handler will call
	 * live update of editable element
	 *
	 * @var string
	 */
	public $liveTarget = null;
	/**
	 * jQuery selector of elements to wich will be applied editable.
	 * Usefull in combination of `liveTarget` when you want to keep field(s) editble
	 * after ajaxUpdate
	 *
	 * @var string
	 */
	public $liveSelector = null;

	// --- X-editable events ---
	/**
	 * A javascript function that will be invoked when editable element is initialized
	 * @var string
	 * @package event
	 * @see x-editable
	 */
	public $onInit;
	/**
	 * A javascript function that will be invoked when editable form is shown
	 * Example:
	 * <pre>
	 * 'onShown' => 'js: function() {
	 *     var $tip = $(this).data("editableContainer").tip();
	 *     $tip.find("input").val("overwriting value of input.");
	 * }'
	 * </pre>
	 *
	 * @var string
	 * @package event
	 * @see x-editable
	 */
	public $onShown;
	/**
	 * A javascript function that will be invoked when new value is saved
	 * Example:
	 * <pre>
	 * 'onSave' => 'js: function(e, params) {
	 *     alert("Saved value: " + params.newValue);
	 * }'
	 * </pre>
	 *
	 * @var string
	 * @package event
	 * @see x-editable
	 */
	public $onSave;
	/**
	 * A javascript function that will be invoked when editable form is hidden
	 * Example:
	 * <pre>
	 * 'onHidden' => 'js: function(e, reason) {
	 *    if(reason === "save" || reason === "cancel") {
	 *        //auto-open next editable
	 *        $(this).closest("tr").next().find(".editable").editable("show");
	 *    }
	 * }'
	 * </pre>
	 *
	 * @var string
	 * @package event
	 * @see x-editable
	 */
	public $onHidden;

	/**
	 * @var array all config options of x-editable. See full list <a href="http://vitalets.github.com/x-editable/docs.html#editable">here</a>.
	 */
	public $options = array();

	/**
	 * @var array HTML options of element. In `EditableColumn` htmlOptions are PHP expressions
	 * so you can use `$data` to bind values to particular cell, e.g. `'data-categoryID' => '$data->categoryID'`.
	 */
	public $htmlOptions = array();

	/**
	 * @var boolean whether to HTML encode text on output
	 */
	public $encode = true;

	/**
	 * @var boolean whether to apply 'editable' js plugin to element.
	 * Only **safe** attributes become editable.
	 */
	public $apply = null;

	/**
	 * @var string title of popup. If `null` - will be generated automatically from attribute label.
	 * Can have token {label} inside that will be replaced with actual attribute label.
	 */
	public $title = null;

	/**
	 * @var string for jQuery UI only. The JUI theme name.
	 */
	public $theme = 'base';


	protected $_prepareToAutotext = false;

	/**
	 * initialization of widget
	 *
	 */
	public function init()
	{
		parent::init();

		if (!$this->name) {
			throw new CException('Parameter "name" should be provided for Editable widget');
		}

		$this->attachBehavior('ywplugin', array('class' => 'yiiwheels.behaviors.WhPlugin'));
		$this->_prepareToAutotext = self::isAutotext($this->options, $this->type);
	}

	/**
	 * Builds html options
	 */
	public function buildHtmlOptions()
	{
		//html options
		$htmlOptions = array(
			'href' => '#',
			'rel' => $this->liveSelector ? $this->liveSelector : $this->getSelector(),
		);

		//set data-pk
		if ($this->pk !== null) {
			$htmlOptions['data-pk'] = is_array($this->pk) ? CJSON::encode($this->pk) : $this->pk;
		}

		//if input type assumes autotext (e.g. select) we define value directly in data-value
		//and do not fill element contents
		if ($this->_prepareToAutotext) {
			//for date we use 'format' to put it into value (if text not defined)
			if ($this->type == 'date') {
				//if date comes as object, format it to string
				if ($this->value instanceOf DateTime || is_long($this->value)) {
					/*
					* unfortunatly datepicker's format does not match Yii locale dateFormat,
					* we need replacements below to convert date correctly
					*/
					$count = 0;
					$format = str_replace('MM', 'MMMM', $this->format, $count);
					if (!$count) $format = str_replace('M', 'MMM', $format, $count);
					if (!$count) $format = str_replace('m', 'M', $format);

					if ($this->value instanceof DateTime) {
						$timestamp = $this->value->getTimestamp();
					} else {
						$timestamp = $this->value;
					}

					$this->value = Yii::app()->dateFormatter->format($format, $timestamp);
				}
			}

			if (is_scalar($this->value)) {
				$this->htmlOptions['data-value'] = $this->value;
			}
			//if not scalar, value will be added to js options instead of html options
		}

		//merging options
		$this->htmlOptions = CMap::mergeArray($this->htmlOptions, $htmlOptions);

		//convert arrays to json string, otherwise yii can not render it:
		//"htmlspecialchars() expects parameter 1 to be string, array given"
		foreach ($this->htmlOptions as $k => $v) {
			$this->htmlOptions[$k] = is_array($v) ? CJSON::encode($v) : $v;
		}
	}

	/**
	 * Builds javascript options
	 */
	public function buildJsOptions()
	{
		//normalize url from array
		$this->url = CHtml::normalizeUrl($this->url);

		$options = array(
			'name' => $this->name,
			'title' => CHtml::encode($this->title),
		);

		//if value needed for autotext and it's not scalar --> add it to js options
		if ($this->_prepareToAutotext && !is_scalar($this->value)) {
			$options['value'] = $this->value;
		}

		//support of CSRF out of box, see https://github.com/vitalets/x-editable-yii/issues/38
		if (Yii::app()->request->enableCsrfValidation) {
			$csrfTokenName = Yii::app()->request->csrfTokenName;
			$csrfToken = Yii::app()->request->csrfToken;
			if (!isset($this->params[$csrfTokenName])) {
				$this->params[$csrfTokenName] = $csrfToken;
			}
		}

		//simple options set directly from config
		foreach (array(
					 'url',
					 'type',
					 'mode',
					 'placement',
					 'emptytext',
					 'params',
					 'inputclass',
					 'format',
					 'viewformat',
					 'template',
					 'combodate',
					 'select2',
					 'viewseparator',
					 'showbuttons',
					 'send',
				 ) as $option) {
			if ($this->$option !== null) {
				$options[$option] = $this->$option;
			}
		}

		if ($this->source) {

			//if source is array --> convert it to x-editable format.
			//Since 1.1.0 source as array with one element is NOT treated as Yii route!
			if (is_array($this->source)) {
				//if first elem is array assume it's normal x-editable format, so just pass it
				if (isset($this->source[0]) && is_array($this->source[0])) {
					$options['source'] = $this->source;
				} else { //else convert to x-editable source format {value: 1, text: 'abc'}
					$options['source'] = array();
					foreach ($this->source as $value => $text) {
						$options['source'][] = array('value' => $value, 'text' => $text);
					}
				}
			} else { //source is url string (or js function)
				$options['source'] = CHtml::normalizeUrl($this->source);
			}
		}

		//callbacks
		foreach (array('validate', 'success', 'display') as $method) {
			if (isset($this->$method)) {
				$options[$method] = (strpos($this->$method, 'js:') !== 0 ? 'js:' : '') . $this->$method;
			}
		}

		//merging options
		$this->options = CMap::mergeArray($this->options, $options);

		//i18n for `clear` in date and datetime
		if ($this->type == 'date' || $this->type == 'datetime') {
			if (!isset($this->options['clear'])) {
				$this->options['clear'] = Yii::t('EditableField.editable', 'x clear');
			}
		}
	}

	/**
	 * Registers client script
	 * @return string
	 */
	public function registerClientScript()
	{
		$selector = "a[rel=\"{$this->htmlOptions['rel']}\"]";
		if ($this->liveTarget) {
			$selector = '#' . $this->liveTarget . ' ' . $selector;
		}
		$script = "$('" . $selector . "')";

		//attach events
		foreach (array('init', 'shown', 'save', 'hidden') as $event) {
			$eventName = 'on' . ucfirst($event);
			if (isset($this->$eventName)) {
				// CJavaScriptExpression appeared only in 1.1.11, will turn to it later
				//$event = ($this->onInit instanceof CJavaScriptExpression) ? $this->onInit : new CJavaScriptExpression($this->onInit);
				$eventJs = (strpos($this->$eventName, 'js:') !== 0 ? 'js:' : '') . $this->$eventName;
				$script .= "\n.on('" . $event . "', " . CJavaScript::encode($eventJs) . ")";
			}
		}

		//apply editable
		$options = CJavaScript::encode($this->options);
		$script .= ".editable($options);";

		//wrap in anonymous function for live update
		if ($this->liveTarget) {
			$script .= "\n $('body').on('ajaxUpdate.editable', function(e){ if(e.target.id == '" . $this->liveTarget . "'){yiiEditable();}});";
			$script = "(function yiiEditable() {\n " . $script . "\n}());";
		}

		Yii::app()->getClientScript()->registerScript(__CLASS__ . '-' . $selector, $script);

		return $script;
	}

	/**
	 * Registers assets
	 * @throws CException
	 */
	public function registerAssets()
	{
		$cs = Yii::app()->getClientScript();


		$path = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'bootstrap-editable';
		$assetsUrl = $this->getAssetsUrl($path);

		//register assets
		$cs->registerCssFile($assetsUrl . '/css/bootstrap-editable.css');
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-editable.js', CClientScript::POS_END);

		//include moment.js for combodate
		if ($this->type == 'combodate') {
			$path = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'moment';
			$momentUrl = Yii::app()->assetManager->publish($path, false, -1, $this->getApi()->forceCopyAssets);
			$cs->registerScriptFile($momentUrl . '/moment.min.js');
		}

		//include select2 lib for select2 type
		if ($this->type == 'select2') {
			$path = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'select2';
			$select2Url = Yii::app()->assetManager->publish($path, false, -1, $this->getApi()->forceCopyAssets);
			$cs->registerScriptFile($select2Url . '/select2.min.js');
			$cs->registerCssFile($select2Url . '/select2.css');
		}

		//include bootstrap-datetimepicker
		if ($this->type == 'datetime') {
			$path = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'bootstrap-datetimepicker';
			$dateTimePickerUrl = Yii::app()->assetManager->publish($path, false, -1, $this->getApi()->forceCopyAssets);
			$cs->registerScriptFile($dateTimePickerUrl . '/js/bootstrap-datetimepicker.js');
			$cs->registerCssFile($dateTimePickerUrl . '/css/datetimepicker.css');
		}
	}

	/**
	 * Widget run method
	 */
	public function run()
	{
		//Register script (even if apply = false to support live update)
		if ($this->apply !== false || $this->liveTarget) {
			$this->buildHtmlOptions();
			$this->buildJsOptions();
			$this->registerAssets();
			$this->registerClientScript();
		}

		if ($this->apply !== false) {
			$this->renderLink();
		} else {
			$this->renderText();
		}
	}

	/**
	 * Renders a link
	 */
	public function renderLink()
	{
		echo CHtml::openTag('a', $this->htmlOptions);
		$this->renderText();
		echo CHtml::closeTag('a');
	}

	/**
	 * Renders text
	 */
	public function renderText()
	{
		$encodedText = $this->encode ? CHtml::encode($this->text) : $this->text;
		if ($this->type == 'textarea') {
			$encodedText = preg_replace('/\r?\n/', '<br>', $encodedText);
		}
		echo $encodedText;
	}

	/**
	 * Returns the plugin selector
	 * @return null|string
	 */
	public function getSelector()
	{
		//for live updates selector should not contain pk
		if ($this->liveTarget) {
			return $this->name;
		}

		$pk = $this->pk;
		if ($pk === null) {
			$pk = 'new';
		} else {
			//support of composite keys: convert to string: e.g. 'id-1_lang-ru'
			if (is_array($pk)) {
				//below not works in PHP < 5.3, see https://github.com/vitalets/x-editable-yii/issues/39
				//$pk = join('_', array_map(function($k, $v) { return $k.'-'.$v; }, array_keys($pk), $pk));
				$buffer = array();
				foreach ($pk as $k => $v) {
					$buffer[] = $k . '-' . $v;
				}
				$pk = join('_', $buffer);
			}
		}


		return $this->name . '_' . $pk;
	}

	/**
	 * Returns is autotext should be applied to widget:
	 * e.g. for 'select' to display text for id
	 *
	 * @param mixed $options
	 * @param mixed $type
	 * @return bool
	 */
	public static function isAutotext($options, $type)
	{
		return (!isset($options['autotext']) || $options['autotext'] !== 'never')
		&& in_array($type, array(
			'select',
			'checklist',
			'date',
			'datetime',
			'dateui',
			'combodate',
			'select2'
		));
	}

	/**
	 * Returns php-array as valid x-editable source in format:
	 * [{value: 1, text: 'text1'}, {...}]
	 *
	 * See https://github.com/vitalets/x-editable-yii/issues/37
	 *
	 * @param mixed $models
	 * @param mixed $valueField
	 * @param mixed $textField
	 * @param mixed $groupField
	 * @param mixed $groupTextField
	 * @return array
	 */
	public static function source($models, $valueField = '', $textField = '', $groupField = '', $groupTextField = '')
	{
		$listData = array();

		$first = reset($models);

		//simple 1-dimensional array: 0 => 'text 0', 1 => 'text 1'
		if ($first && (is_string($first) || is_numeric($first))) {
			foreach ($models as $key => $text) {
				$listData[] = array('value' => $key, 'text' => $text);
			}
			return $listData;
		}

		// 2-dimensional array or dataset
		if ($groupField === '') {
			foreach ($models as $model) {
				$value = CHtml::value($model, $valueField);
				$text = CHtml::value($model, $textField);
				$listData[] = array('value' => $value, 'text' => $text);
			}
		} else {
			if (!$groupTextField) {
				$groupTextField = $groupField;
			}
			$groups = array();
			foreach ($models as $model) {
				$group = CHtml::value($model, $groupField);
				$groupText = CHtml::value($model, $groupTextField);
				$value = CHtml::value($model, $valueField);
				$text = CHtml::value($model, $textField);
				if ($group === null) {
					$listData[] = array('value' => $value, 'text' => $text);
				} else {
					if (!isset($groups[$group])) {
						$groups[$group] = array(
							'value' => $group,
							'text' => $groupText,
							'children' => array(),
							'index' => count($listData)
						);
						$listData[] = 'group'; //placeholder, will be replaced in future
					}
					$groups[$group]['children'][] = array('value' => $value, 'text' => $text);
				}
			}

			//fill placeholders with group data
			foreach ($groups as $group) {
				$index = $group['index'];
				unset($group['index']);
				$listData[$index] = $group;
			}
		}

		return $listData;
	}

	/**
	 * injects ajaxUpdate event into widget
	 *
	 * @param mixed $widget
	 */
	public static function attachAjaxUpdateEvent($widget)
	{
		$trigger = '$("#' . $widget->id . '").trigger("ajaxUpdate.editable");';

		//check if trigger already inserted by another column
		if (strpos($widget->afterAjaxUpdate, $trigger) !== false) return;

		//inserting trigger
		if (strlen($widget->afterAjaxUpdate)) {
			$orig = $widget->afterAjaxUpdate;
			if (strpos($orig, 'js:') === 0) $orig = substr($orig, 3);
			$orig = "\n($orig).apply(this, arguments);";
		} else {
			$orig = '';
		}
		$widget->afterAjaxUpdate = "js: function(id, data) {
            $trigger $orig
        }";

		$widget->registerClientScript();
	}

}
