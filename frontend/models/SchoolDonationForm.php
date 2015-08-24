<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

class SchoolDonationForm extends Model
{
	public $schoolDonationType;
	public $schoolId;
	public $schoolName;
	public $schoolDonationTypes = [
		'1' => 'The Education Incentive Fund',
		'2' => 'A Specific School'
	];

	public function rules()
	{
		return array(
			['schoolDonationType', 'required'],
			['schoolDonationType', 'validateSpecificSchool'],	
            [['schoolId', 'schoolDonationType', 'schoolName'], 'safe'],
		);
	}
	
	public function validateSpecificSchool()
	{
		if($this->schoolDonationType == 2 && !($this->schoolId && $this->schoolName))
		{
			$this->addError('schoolDonationType', 'Please choose a specific school.');
		}
	}
}
