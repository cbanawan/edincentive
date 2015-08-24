<?php
namespace common\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\mail\BaseMailer;
 
class GAEMailer extends BaseMailer 
{
	public $messageClass = 'common\components\GAEMailMessage';
	
	protected function sendMessage($message)
	{
		return $message->send();
	}
}
?>
