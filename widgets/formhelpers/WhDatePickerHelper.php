<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('yiiwheels.widgets.formhelpers.WhInputWidget');

/**
 * WhDatePickerHelper widget class
 *
 * Implements Bootstrap Form Helpers DatePicker
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package YiiWheels.widgets.bootstrap-form-helpers
 */
class WhDatePickerHelper extends WhInputWidget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        TbHtml::addCssClass('bfh-datepicker', $this->htmlOptions);

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo CHtml::tag('div', $this->htmlOptions, '');

        $this->registerPlugin('bfhdatepicker');
    }
}