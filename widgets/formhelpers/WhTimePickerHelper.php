<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
Yii::import('yiiwheels.widgets.formhelpers.WhInputWidget');

/**
 * WhTimePickerHelper widget class
 *
 * Implements Bootstrap Form Helper timepicker plugin
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package YiiWheels.widgets.bootstrap-form-helpers
 */
class WhTimePickerHelper extends WhInputWidget
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        TbHtml::addCssClass('bfh-timepicker', $this->htmlOptions);

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo CHtml::tag('div', $this->htmlOptions, '');

        $this->registerPlugin('bfhtimepicker');
    }
}