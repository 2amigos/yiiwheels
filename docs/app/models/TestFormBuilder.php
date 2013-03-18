<?php
/**
 * TestFormBuilder.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 10/22/12
 * Time: 2:05 PM
 */
class TestFormBuilder extends CFormModel
{
	public $search;
	public $agree;
	public $radiolist;

	public function rules()
	{
		return array(
			array('search', 'required'),
			array('agree,radiolist', 'boolean'),
			array('agree', 'compare', 'compareValue' => true,
				'message' => 'You must agree...'),

		);
	}

	// Change the labels here
	public function attributeLabels()
	{
		return array(
			'search' => 'Text search',
			'selectlist' => 'I agree',
		);
	}

	// return the formbuilder config
	public function getFormConfig()
	{
		return array(
			'title' => 'Formbuilder test form',
			'showErrorSummary' => true,
			'elements' => array(
				'search' => array(
					'type' => 'text',
					'maxlength' => 32,
					'hint' => 'This is a hint',
					'placeholder' => 'title',
					'class' => 'input-large',
					'append' => '<i class="icon-search"></i>',
				),
				'agree' => array(
					'type' => 'checkbox',
					// 'hint' => 'Agree to terms and conditions',
				),
				'radiolist' => array(
					'type' => 'radiolistinline',
					'items' => array('item1' => '1', 'item2' => '2', 'item3' => '3'),
				),
			),

			'buttons' => array(
				'submit' => array(
					'type' => 'submit', //@see TbFormButtonElement::$TbButtonTypes
					'layoutType' => 'primary', //@see TbButton->type
					'label' => 'Submit',
				),
				'reset' => array(
					'type' => 'reset',
					'label' => 'Reset',
				),
			),
		);
	}
}