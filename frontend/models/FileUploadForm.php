<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

class FileUploadForm extends Model
{
	public $title;
	public $author;
	public $description;
	public $fileName;
	
	const EXTENSIONS = '3gp,act,AIFF,aac,ALAC,amr,atrac,Au,awb,dct,dss,dvf,flac,gsm,iklax,IVS,m4a,m4p,mmf,mp3,mpc,msv,ogg,Opus,ra,rm,raw,TTA,vox,wav,wma';


	public function rules()
	{
		return array(
			array(['fileName', 'title'],'required'),
			array('fileName', 'file', 'extensions' => self::EXTENSIONS, 'checkExtensionByMimeType' => false),
			array(['fileName', 'title', 'author', 'description'], 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'fileName' => 'Audio File',
			'title' => 'Title',
			'description' => 'Description',
			'author' => 'Author',
			);
	}

}
