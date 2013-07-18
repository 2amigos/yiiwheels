<?php
/**
 * WhRedactor class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets.redactor
 * @uses YiiStrap.helpers.TbHtml
 */
Yii::import('bootstrap.helpers.TbHtml');

class WhRedactor extends CInputWidget
{
    /**
     * Editor options that will be passed to the editor
     * @see http://imperavi.com/redactor/docs/
     */
    public $pluginOptions = array();

    /**
     * Debug mode
     * Used to publish full js file instead of min version
     */
    public $debugMode = false;

    /**
     * Widget's init function
     */
    public function init()
    {

        $this->attachBehavior('ywplugin', array('class' => 'yiiwheels.behaviors.WhPlugin'));

        if (!$style = TbHtml::popOption('style', $this->htmlOptions, '')) {
            $this->htmlOptions['style'] = $style;
        }

        $width                      = TbHtml::getOption('width', $this->htmlOptions, '100%');
        $height                     = TbHtml::popOption('height', $this->htmlOptions, '450px');
        $this->htmlOptions['style'] = "width:{$width};height:{$height};" . $this->htmlOptions['style'];
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

        if ($this->hasModel()) {
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        } else {
            echo CHtml::textArea($name, $this->value, $this->htmlOptions);
        }

    }

    /**
     * Registers required client script for bootstrap select2. It is not used through bootstrap->registerPlugin
     * in order to attach events if any
     */
    public function registerClientScript()
    {
        /* publish assets dir */
        $path      = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assetsUrl = $this->getAssetsUrl($path);

        /* @var $cs CClientScript */
        $cs = Yii::app()->getClientScript();

        $script = $this->debugMode
            ? 'redactor.js'
            : 'redactor.min.js';

        $cs->registerCssFile($assetsUrl . '/css/redactor.css');
        $cs->registerScriptFile($assetsUrl . '/js/' . $script);

        /* register language */
        $language = TbHtml::getOption('lang', $this->pluginOptions);
        if (!empty($language) && $language != 'en') {
            $cs->registerScriptFile($assetsUrl . '/js/langs/' . $language . '.js', CClientScript::POS_END);
        }

        /* register plugins (if any) */
        $this->registerPlugins($assetsUrl);

        /* initialize plugin */
        $selector = '#' . TbHtml::getOption('id', $this->htmlOptions, $this->getId());

        $this->getApi()->registerPlugin('redactor', $selector, $this->pluginOptions);
    }

    /**
     * @param $assetsUrl
     */
    protected function registerPlugins($assetsUrl)
    {
        if (isset($this->pluginOptions['plugins'])) {
            $ds          = DIRECTORY_SEPARATOR;
            $pluginsPath = __DIR__ . $ds . 'assets' . $ds . 'js' . $ds . 'plugins';
            $pluginsUrl  = $assetsUrl . '/js/plugins/';
            $scriptTypes = array('css', 'js');

            foreach ($this->pluginOptions['plugins'] as $pluginName) {
                foreach ($scriptTypes as $type) {
                    if (@file_exists($pluginsPath . $pluginName . $ds . $pluginName . '.' . $type)) {
                        Yii::app()->clientScript->registerScriptFile(
                            $pluginsUrl . '/' .
                                $pluginName . '/' .
                                $pluginName . '.' .
                                $type
                        );
                    }
                }
            }
        }
    }
}