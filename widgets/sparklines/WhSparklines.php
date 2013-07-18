<?php
/**
 * WhSparkLines class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets.sparklines
 * @uses YiiStrap.helpers.TbHtml
 */
Yii::import('bootstrap.helpers.TbHtml');

class WhSparkLines extends CWidget
{
    /**
     * @var string the tag name to render the sparkline to
     * NOTE: span type of tag may have issues.
     */
    public $tagName = 'div';

    /**
     * @var array the data to show on the chart
     * @see http://omnipotent.net/jquery.sparkline/#s-about
     */
    public $data = array();

    /**
     * @var array additional HTML attributes to the tag
     */
    public $htmlOptions = array();

    /**
     * @var array plugin options
     */
    public $pluginOptions = array();

    /**
     * Debug mode
     * Used to publish full js file instead of min version
     */
    public $debugMode = false;

    /**
     * Widget's initialization method
     */
    public function init()
    {
        if (empty($this->data)) {
            throw new CException(Yii::t('zii', '"data" attribute cannot be blank'));
        }

        $this->attachBehavior('ywplugin', array('class' => 'yiiwheels.behaviors.WhPlugin'));

        $this->htmlOptions['id'] = TbHtml::getOption('id', $this->htmlOptions, $this->getId());
    }

    /**
     * Widget's run method
     */
    public function run()
    {
        echo CHtml::openTag($this->tagName, $this->htmlOptions);
        echo CHtml::closeTag($this->tagName);
        $this->registerClientScript();
    }

    /**
     * Registers required client script for sparklines
     */
    public function registerClientScript()
    {
        /* publish assets dir */
        $path      = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assetsUrl = $this->getAssetsUrl($path);

        /* @var $cs CClientScript */
        $cs = Yii::app()->getClientScript();

        $script = $this->debugMode
            ? 'jquery.sparkline.js'
            : 'jquery.sparkline.min.js';

        $cs->registerScriptFile($assetsUrl . '/js/' . $script);

        /* initialize plugin */
        $selector = '#' . TbHtml::getOption('id', $this->htmlOptions, $this->getId());

        $data    = CJavaScript::encode($this->data);
        $options = CJavaScript::encode($this->pluginOptions);

        $cs->registerScript(__CLASS__ . '#' . $selector, "jQuery('{$selector}').sparkline({$data}, {$options});");
    }
}