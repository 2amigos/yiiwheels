<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('yiiwheels.widgets.formhelpers.WhInputWidget');

/**
 *
 * WhSelectBox widget class
 *
 * Implements Bootstrap Form Helper select box plugin
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package YiiWheels.widgets.bootstrap-form-helpers
 */
class WhSelectBox extends WhInputWidget
{
    /**
     * @var array the array keys are option values, and the array values
     * are the corresponding option labels.
     */
    public $data = array();

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        TbHtml::addCssClass('bfh-selectbox', $this->htmlOptions);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $input[] = CHtml::openTag('div', $this->htmlOptions);
        foreach ($this->data as $key => $value) {
            $input[] = CHtml::tag('div', array('data-value' => (string)$key), (string)$value);
        }
        $input[] = CHtml::closeTag('div');

        echo implode("\n", $input);

        $this->registerPlugin('bfhselectbox');
    }
} 