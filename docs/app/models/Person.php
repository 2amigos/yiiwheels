<?php
class Person extends CModel
{
	public $id;
	public $firstName;
	public $lastName;
	public $language;
	public $hours;
	public $firstLetter;

	public function attributeNames()
	{
		return array(
			'id',
			'firstName',
			'lastName',
			'language',
			'hours'
		);
	}

	public function search()
	{
		return new Person();
	}
}
