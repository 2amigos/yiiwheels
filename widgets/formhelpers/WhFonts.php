<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('yiiwheels.widgets.formhelpers.WhDropDownInputWidget');

/**
 * WhFonts widget class
 * Implements Bootstrap Form Helpers Font widget
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package YiiWheels.widgets.bootstrap-form-helpers
 */
class WhFonts extends WhDropDownInputWidget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        TbHtml::addCssClass('bfh-fonts', $this->htmlOptions);

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

        echo $this->dropDownList();

        $this->registerPlugin('bfhfonts');
    }
}