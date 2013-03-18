<?php
class TestForm extends CFormModel
{

	public $textField;
	public $dateField;
	public $redactor;
	public $dropdown;
	public $checkbox;
	public $checkboxes;
	public $inlineCheckboxes;
	public $radioButton;
	public $radioButtons;
	public $inlineRadioButtons;
	public $password;
	public $textarea;
	public $multiSelect;
	public $select2;


	public $dateRangeField;
	public $wysihtml5;
	public $multiDropdown;
	public $fileField;
	public $uneditable;
	public $disabled;
	public $prepend;
	public $append;
	public $disabledCheckbox;
	public $captcha;
	public $toggle;
	public $colorpicker;
	public $ckeditor;
	public $timepicker;
	public $markdown;

	public $rangeSlider;

	public function afterConstruct()
	{
		$this->dateField = date('d/m/Y');
	}

	public function attributeLabels()
	{
		return array(
			'textField'=>'Text input',
			'dateField'=>'Date input',
			'dateRangeField' => 'Date range input',
			'dropdown'=>'Select list',
			'multiDropdown'=>'Multiple select',
			'checkbox'=>'Check me out',
			'inlineCheckboxes'=>'Inline checkboxes',
			'radioButtons'=>'Radio buttons',
			'fileField'=>'File input',
			'uneditable'=>'Uneditable input',
			'redactor' => 'Redactor WYSIWYG',
			'wysihtml5' => 'Bootstrap WYSIHTML5',
			'disabled'=>'Disabled input',
			'prepend'=>'Prepend text',
			'append'=>'Append text',
			'disabledCheckbox'=>'Disabled checkbox',
			'toggle'=>'Toggle Button',
			'colorpicker'=>'Color input',
			'ckeditor' => 'CKEditor WYSIWYG',
			'markdown' => 'Markdown Editor',
			'timepicker' => 'Time picker Field',
			'select2' => 'Select2 Field',
			'rangeSlider' => 'JQRangeSlider Field'
		);
	}
}
