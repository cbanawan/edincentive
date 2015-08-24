<?php
/**
 *SocialShareButton.php
 *
 * @author Rohit Suthar <rohit.suthar@gmail.com>
 * @copyright 2014 Rohit Suthar
 * @package SocialShareButton
 * @version 1.0
 */
namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class SocialShareButton extends Widget
{
	
	/**
	 * @var string box alignment - horizontal, vertical
	 */
	public $style='horizontal';
	
	
	/**
	 * @var string twitter username - rohisuthar
	 */
	public $data_via='';


	/**
	 * @var array available social media share buttons 
	 * like - facebook, googleplus, linkedin, twitter
	 */
	
	public $networks = ['facebook','googleplus','linkedin','twitter','pinterest'];
	
	public $url = null;
	
	public $addlParams = null;


	/**
	 * The extension initialisation
	 *
	 * @return nothing
	 */

	public function init()
	{
		parent::init();
		
		self::renderSocial();
		if(!$this->url)
		{
			$this->url = Yii::$app->getRequest()->absoluteUrl;
		}
	}


	/**
	 * Render social extension
	 *
	 * @return nothing
	 */
	private function renderSocial(){
		$rendered = '';
		$width = 80/count($this->networks);
		$params = ['url' => $this->url, 'width' => $width, 'style' => $this->style];
		
		if($this->addlParams)
		{
			$params = array_merge($params, $this->addlParams);
		}
		
		foreach($this->networks as $network)
		{
			$rendered .= $this->render('socialshare/' . $network, $params);
		}
		
		echo $this->render('socialshare/share', ['rendered'=>$rendered]);
	}
}

?>
