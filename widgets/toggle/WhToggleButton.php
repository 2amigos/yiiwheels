<?php
/**
 * WhToggleButton widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets.toggle
 * @uses YiiStrap.helpers.TbArray
 */
Yii::import('bootstrap.helpers.TbArray');

class WhToggleButton extends CInputWidget
{

    /**
     * @var string the javascript function
     *
     * The function signature is <code>function($el, status, e)</code>
     * <ul>
     * <li><code>$el</code> the toggle element changed. </li>
     * <li><code>status</code> the status of the element (true=on | false=off) </li>
     * <li><code>e</code> the event object </li>
     * </ul>
     *
     * Example:
     * <pre>
     *  array(
     *     class'=>'WhToggleColumn',
     *     'onChange'=>'js:function($el, status, e){ console.log($el, status, e); }',
     *  ),
     * </pre>
     */
    public $onChange;

    /**
     * @var int the width of the toggle button
     */
    public $width = 100;

    /**
     * @var int the height of the toggle button
     */
    public $height = 25;

    /**
     * @var bool whether to use animation or not
     */
    public $animated = true;

    /**
     * @var mixed the transition speed (toggle movement)
     */
    public $transitionSpeed; //accepted values: float or percent [1, 0.5, '150%']

    /**
     * @var string the label to display on the enabled side
     */
    public $enabledLabel = 'ON';

    /**
     * @var string the label to display on the disabled side
     */
    public $disabledLabel = 'OFF';

    /**
     * @var string the style of the toggle button enable style
     * Accepted values ["primary", "danger", "info", "success", "warning"] or nothing
     */
    public $enabledStyle = 'primary';

    /**
     * @var string the style of the toggle button disabled style
     * Accepted values ["primary", "danger", "info", "success", "warning"] or nothing
     */
    public $disabledStyle = null;

    /**
     * @var array a custom style for the enabled option. Format
     * <pre>
     *  ...
     *  'customEnabledStyle'=>array(
     *      'background'=>'#FF00FF',
     *      'gradient'=>'#D300D3',
     *      'color'=>'#FFFFFF'
     *  ),
     *  ...
     * </pre>
     */
    public $customEnabledStyle = array();

    /**
     * @var array a custom style for the disabled option. Format
     * <pre>
     *  ...
     *  'customDisabledStyle'=>array(
     *      'background'=>'#FF00FF',
     *      'gradient'=>'#D300D3',
     *      'color'=>'#FFFFFF'
     *  ),
     *  ...
     * </pre>
     */
    public $customDisabledStyle = array();

    /**
     * @var string the tag name. Defaults to 'div'.
     */
    public $tagName = 'div';

    /**
     * Widget's initialization method
     */
    public function init()
    {
        $this->attachBehavior('ywplugin', array('class' => 'yiiwheels.behaviors.WhPlugin'));
        $this->htmlOptions['id'] = TbArray::getValue('id', $this->htmlOptions, $this->getId());
    }

    /**
     * Widget's run function
     */
    public function run()
    {
        $this->renderField();
        $this->registerClientScript();
    }

    /**
     * Renders the input field
     */
    public function renderField()
    {
        list($name, $id) = $this->resolveNameID();

        echo CHtml::openTag($this->tagName, array('id' => 'wrapper-' . $id));

        if ($this->hasModel()) {
            echo CHtml::activeCheckBox($this->model, $this->attribute, $this->htmlOptions);
        } else {
            echo CHtml::checkBox($name, $this->value, $this->htmlOptions);
        }

        echo CHtml::closeTag($this->tagName);
    }

    /**
     * Registers client scripts
     */
    protected function registerClientScript()
    {

        $path      = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assetsUrl = $this->getAssetsUrl($path);

        /* @var $cs CClientScript */
        $cs = Yii::app()->clientScript;

        $cs->registerCoreScript('jquery');

        $cs->registerCssFile($assetsUrl . '/css/bootstrap-toggle-buttons.css');
        $cs->registerScriptFile($assetsUrl . '/js/jquery.toggle.buttons.js');

        /* initialize plugin */
        $selector = '#wrapper-' . TbArray::getValue('id', $this->htmlOptions, $this->getId());

        $this->getApi()->registerPlugin(
            'toggleButtons',
            $selector,
            $this->getConfiguration(),
            CClientScript::POS_READY
        );

    }

    /**
     * @return array the configuration of the plugin
     */
    protected function getConfiguration()
    {
        if ($this->onChange !== null) {
            if ((!$this->onChange instanceof CJavaScriptExpression) && strpos($this->onChange, 'js:') !== 0) {
                $onChange = new CJavaScriptExpression($this->onChange);
            } else {
                $onChange = $this->onChange;
            }
        } else {
            $onChange = 'js:$.noop';
        }

        $config = array(
            'onChange'        => $onChange,
            'width'           => $this->width,
            'height'          => $this->height,
            'animated'        => $this->animated,
            'transitionSpeed' => $this->transitionSpeed,
            'label'           => array(
                'enabled'  => $this->enabledLabel,
                'disabled' => $this->disabledLabel
            ),
            'style'           => array()
        );
        if (!empty($this->enabledStyle)) {
            $config['style']['enabled'] = $this->enabledStyle;
        }
        if (!empty($this->disabledStyle)) {
            $config['style']['disabled'] = $this->disabledStyle;
        }
        if (!empty($this->customEnabledStyle)) {
            $config['style']['custom'] = array('enabled' => $this->customEnabledStyle);
        }
        if (!empty($this->customDisabledStyle)) {
            if (isset($config['style']['custom'])) {
                $config['style']['custom']['disabled'] = $this->customDisabledStyle;
            } else {
                $config['style']['custom'] = array('disabled' => $this->customDisabledStyle);
            }
        }
        foreach ($config as $key => $element) {
            if (empty($element)) {
                unset($config[$key]);
            }
        }
        return $config;
    }
}
