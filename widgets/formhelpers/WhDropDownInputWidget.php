<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('yiiwheels.widgets.formhelpers.WhInputWidget');

/**
 *
 * WhDropdownInputWidget widget class
 * Base class for dropdown input type bootstrap helper plugins.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package YiiWheels.widgets.bootstrap-form-helpers
 */
class WhDropDownInputWidget extends WhInputWidget
{
    /**
     * @var bool whether to use [[Select]] or not
     */
    public $useHelperSelectBox = false;

    /**
     * Renders a dropdown list for the helper
     */
    protected function dropDownList()
    {
        if (!$this->useHelperSelectBox) {
            return $this->hasModel()
                ? CHtml::activeDropDownList($this->model, $this->attribute, array(), $this->htmlOptions)
                : CHtml::dropDownList($this->name, $this->value, array(), $this->htmlOptions);
        } else {


            ob_start();
            ob_implicit_flush(false);
            try {
                $widget = Yii::createComponent(
                    array(
                        'class' => 'yiiwheels.widgets.formhelpers.WhSelectBox',
                        'model' => $this->model,
                        'attribute' => $this->attribute,
                        'name' => $this->name,
                        'value' => $this->value,
                        'htmlOptions' => $this->htmlOptions,
                    )
                );
                $widget->init();
                $widget->run();
            } catch (Exception $e) {
                ob_end_clean();
                throw $e;
            }
            return ob_get_clean();
        }
    }

} 