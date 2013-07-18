<?php
/**
 * WhAceEditor widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @author Matt Tabin <amigo.tabin@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets.ace
 * @uses Yiistrap.helpers.TbHtml
 */
Yii::import('bootstrap.helpers.TbHtml');

class WhAceEditor extends CInputWidget
{
    /**
     * @var string the theme
     */
    public $theme = 'clouds';

    /**
     * @var string the editor mode
     */
    public $mode = 'html';

    /**
     * @var array the options for the ace editor
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
        if (empty($this->theme)) {
            throw new CException(Yii::t(
                'zii',
                '"{attribute}" cannot be empty.',
                array('{attribute}' => 'theme')
            ));
        }

        if (empty($this->mode)) {
            throw new CException(Yii::t(
                'zii',
                '"{attribute}" cannot be empty.',
                array('{attribute}' => 'mode')
            ));
        }

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
     * Renders field
     */
    public function renderField()
    {
        list($name, $id) = $this->resolveNameID();

        $this->htmlOptions = TbHtml::defaultOption('id', $id, $this->htmlOptions);
        $this->htmlOptions = TbHtml::defaultOption('name', $name, $this->htmlOptions);

        $tagOptions = $this->htmlOptions;

        $tagOptions['id'] = 'aceEditor_' . $tagOptions['id'];

        echo CHtml::openTag('div', $tagOptions);
        echo CHtml::closeTag('div');

        $this->htmlOptions['style'] = 'display:none';

        if ($this->hasModel()) {
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        } else {
            echo CHtml::textArea($name, $this->value, $this->htmlOptions);
        }

        $this->htmlOptions = $tagOptions;
    }

    /**
     * Registers required client script for bootstrap ace editor.
     */
    public function registerClientScript()
    {
        /* publish assets dir */
        $path      = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assetsUrl = $this->getAssetsUrl($path);

        /* @var $cs CClientScript */
        $cs = Yii::app()->getClientScript();

        $cs->registerScriptFile($assetsUrl . '/js/ace.js');

        $id = TbHtml::getOption('id', $this->htmlOptions, $this->getId());

        /* Global value that will hold the editor */
        $cs->registerScript(uniqid(__CLASS__ . '#' . $id, true), 'var ' . $id . ';', CClientScript::POS_HEAD);

        ob_start();
        /* initialize plugin */
        $selector = TbHtml::getOption('id', $this->htmlOptions, $this->getId());

        echo $selector . '= ace.edit("' . $id . '");' . PHP_EOL;
        echo $selector . '.setTheme("ace/theme/' . $this->theme . '");' . PHP_EOL;
        echo $selector . '.getSession().setMode("ace/mode/' . $this->mode . '");' . PHP_EOL;

        if (!empty($this->events) && is_array($this->events)) {
            foreach ($this->events as $name => $handler) {
                $handler = ($handler instanceof CJavaScriptExpression)
                    ? $handler
                    : new CJavaScriptExpression($handler);

                echo $id . ".getSession().on('{$name}', {$handler});" . PHP_EOL;
            }
        }

        $cs->registerScript(uniqid(__CLASS__ . '#ReadyJS' . $id, true), ob_get_clean());
    }
}