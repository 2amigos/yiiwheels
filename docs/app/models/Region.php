<?php

/**
 * This is the model class for table "{{region}}".
 *
 * The followings are the available columns in table '{{region}}':
 * @property integer $id
 * @property integer $country_id
 * @property string $country_code
 * @property string $name
 * @property integer $create_id
 * @property integer $create_time
 * @property integer $update_id
 * @property integer $update_time
 * @property integer $delete_id
 * @property integer $delete_time
 * @property integer $status
 */
class Region extends CActiveRecord
{
	public $textField;
	public $textArea;
	public $dateField;
	public $dropDown;

	public function afterConstruct()
	{
		// Trick meta data
		$this->getMetaData()->columns['textField'] = '';
		$this->getMetaData()->columns['textArea'] = '';
		$this->getMetaData()->columns['dateField'] = '';
		$this->getMetaData()->columns['dropDown'] = '';
		// set public property for example display
		$this->textField = 'demo text';
		$this->textArea = 'demo textarea';
		$this->dateField = date('d-m-Y');

		$this->dropDown = 1;
	}
	/**
	 * @var type string country name virtual attribute 
	 * used in the region/index filter for eziGridView to search countries by name
	 */
	public $filterCountryName;

	/**
	 * @var type string country name virtual attribute 
	 * used in the add/edit dialog for user to enter country name
	 */
	public $country_name;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Region the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_region';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, country_code','required'),
			array('name, filterCountryName', 'length', 'max'=>45),
//			array('country_name', 'validators.CountryValidator', 'setFields'=>array(
//				'country_id'=>'id',
//				'country_code'=>'code',
//				'country_name'=>'name'
//			)),
			//array('name, country_id', 'validators.UniqueInCountry'),
			array('status', 'safe'),
			array('country_id, country_code, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'country' => array(self::BELONGS_TO, 'Country', 'country_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'country_id' => 'Country',
			'country_name' => 'Country name',
			'country_code' => 'Country code',
			'name' => 'Name',
			'filterCountryName' => 'Country'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.name',$this->name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50
			)
		));
	}

	public function searchForExtendedFilterDemo()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.name',$this->name,true);
		$criteria->addCondition('id<5');
		return new CActiveDataProvider(get_class($this), array('criteria'=>$criteria, 'pagination'=>false));
	}
	/**
	 * Returns the array of results for the autocomplete
	 * ajax query
	 * @param string $term
	 * @return array of results
	 */
	public static function getAutocompleteList($term,$country_name=null)
	{
		$sql = Yii::app()->db->createCommand()
			->select('r.name as value, CONCAT(r.name," [",r.country_code,"]") as label')
			->from('{{region}} r');
		if(null===$country_name)
		{
			$sql=$sql->where('r.name like :name', array(':name'=>'%'.$term.'%'));
		}
		else
		{
			$sql=$sql
				->join('{{country}} c', 'r.country_id=c.id')
				->where('r.name like :name and c.name like :country_name', array(
					':name'=>'%'.$term.'%',
					':country_name'=>'%'.$country_name.'%')
				);
		}
		return $sql->queryAll();
	}
}