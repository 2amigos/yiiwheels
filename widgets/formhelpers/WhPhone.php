<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
Yii::import('yiiwheels.widgets.formhelpers.WhInputWidget');

/**
 * WhPhone widget class
 *
 * Implements Bootstrap Form Helper phone plugin
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package YiiWheels.widgets.bootstrap-form-helpers
 */
class WhPhone extends WhInputWidget
{
    /**
     * @var string the formatting options
     */
    public $format = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        TbHtml::addCssClass('bfh-phone', $this->htmlOptions);

        $this->htmlOptions['data-format'] = $this->format;

        unset($this->htmlOptions['data-name'], $this->htmlOptions['data-value']);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!$this->readOnly) {
            echo $this->hasModel()
                ? CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions)
                : CHtml::textField($this->name, $this->value, $this->htmlOptions);
        } else {
            $this->htmlOptions['data-number'] = $this->hasModel()
                ? $this->model->{$this->attribute}
                : $this->value;
            echo CHtml::tag('span', $this->htmlOptions, '');
        }

        $this->registerPlugin('bfhphone');
    }
}