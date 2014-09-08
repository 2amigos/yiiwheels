<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('yiiwheels.widgets.formhelpers.WhDropDownInputWidget');

/**
 *
 * WhCountries widget class
 * Implements Bootstrap Form Helper Google Font Picker.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package YiiWheels.widgets.bootstrap-form-helpers
 */
class WhGoogleFonts extends WhDropDownInputWidget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        TbHtml::addCssClass('bfh-googlefonts', $this->htmlOptions);

        if (!isset($this->htmlOptions['data-font'])) {
            $this->htmlOptions['data-font'] = TbArray::popValue('data-value', $this->htmlOptions);
        }
        unset($this->htmlOptions['data-name'], $this->htmlOptions['data-value']);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!$this->readOnly) {
            echo $this->dropDownList();
        } else {
            echo CHtml::tag('span', $this->htmlOptions, '');
        }

        $this->registerPlugin('bfhgooglefonts');
    }
}