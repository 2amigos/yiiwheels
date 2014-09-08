<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
Yii::import('yiiwheels.widgets.formhelpers.WhDropDownInputWidget');

/**
 * WhTimezones widget class
 *
 * Implements Bootstrap Form Helper timezones picker plugin
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package YiiWheels.widgets.bootstrap-form-helpers
 */
class WhTimezones extends WhDropDownInputWidget
{

    /**
     * @var string the two letter country code or ID of a bfh-countries HTML element. To filter based on a country.
     * It is required.
     */
    public $country;


    /**
     * @inheritdoc
     * @throws CException
     */
    public function init()
    {
        if (empty($this->country) && !isset($this->pluginOptions['country'])) {
            throw new CException('"$country" cannot be empty.');
        }

        $this->pluginOptions['country'] = TbArray::getValue('country', $this->pluginOptions, $this->country);

        parent::init();

        TbHtml::addCssClass('bfh-timezones', $this->htmlOptions);

        unset($this->htmlOptions['data-name']);
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

        $this->registerPlugin('bfhcountries');
    }
}