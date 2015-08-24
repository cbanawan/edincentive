<?php
namespace common\components;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class CustomActiveRecord extends ActiveRecord
{
    public $rLink;
    
    public function init()
    {
        $result = parent::init();
        $primaryKeys = $this->getTableSchema()->primaryKey;
        
        if(count($primaryKeys) == 1)
        {
            $this->rLink[$primaryKeys[0]] = $primaryKeys[0];
        }
        
        return $result;
    }
    
	/*
	 * This function handles the default values for the
	 * dateCreated and dateLastModified columns
	 */
	public function behaviors()
	{
      return [
          'TimestampBehavior' => [
              'class' => TimestampBehavior::className(),
              'createdAtAttribute' => 'dateCreated',
              'updatedAtAttribute' => ($this->hasAttribute('dateLastModified'))?'dateLastModified':null,
              'value' => new Expression('NOW()'),
          ],
      ];
	}
    
    public function beforeSave($insert)
    {
        if(empty($this->dirtyAttributes))
        {
            $this->detachBehavior('TimestampBehavior');
        }
        return parent::beforeSave($insert);
    }
		
	public function beforeDelete()
	{
		$deletedColumn = lcfirst($this->tableName()).'Deleted';
		if($this->hasAttribute($deletedColumn))
		{
			$this->$deletedColumn = 1;
			$this->save();
			return false;
		}
		
		return parent::beforeDelete();
	}
}

