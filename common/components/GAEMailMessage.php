<?php
namespace common\components;

use \google\appengine\api\mail\Message as GAEOrigMailMessage;
use yii\mail\BaseMessage;
use yii\mail\MessageInterface;

class GAEMailMessage extends BaseMessage implements MessageInterface
{
	private $_mailMessage = null;
	
	public function __construct($config = array())
	{
		$this->_mailMessage = new GAEOrigMailMessage;
		parent::__construct($config);
	}
	public function attach($fileName, array $options = array())
	{
		return $this->_mailMessage->addAttachment($fileName, $options);
	}

	public function attachContent($content, array $options = array())
	{
		
	}

	public function embed($fileName, array $options = array())
	{
		
	}

	public function embedContent($content, array $options = array())
	{
		
	}

	public function getBcc()
	{
		return $this->_mailMessage->getBccList();
	}

	public function getCc()
	{
		return $this->_mailMessage->getCcList();
	}

	public function getCharset()
	{
		
	}

	public function getFrom()
	{
		return $this->_mailMessage->getSender();
	}

	public function getReplyTo()
	{
		return $this->_mailMessage->getReplyTo();
	}

	public function getSubject()
	{
		return $this->_mailMessage->getSubject();
	}

	public function getTo()
	{
		return $this->_mailMessage->getToList();
	}

	public function setBcc($bcc)
	{
		$this->_mailMessage->addBcc($bcc);
		return $this;
	}

	public function setCc($cc)
	{
		$this->_mailMessage->addCc($cc);
		return $this;
	}

	public function setCharset($charset)
	{
		
	}

	public function setFrom($from)
	{
		if(is_array($from))
		{
			$from = key($from);
		}
		
		$this->_mailMessage->setSender($from);
		return $this;
	}

	public function setHtmlBody($html)
	{
		$this->_mailMessage->setHtmlBody($html);
		return $this;
	}

	public function setReplyTo($replyTo)
	{
		$this->_mailMessage->setReplyTo($replyTo);
		return $this;
	}

	public function setSubject($subject)
	{
		$this->_mailMessage->setSubject($subject);
		return $this;
	}

	public function setTextBody($text)
	{
		$this->_mailMessage->setTextBody($text);
		return $this;
	}

	public function setTo($to)
	{
		$this->_mailMessage->addTo($to);
		return $this;
	}
	
	public function send(\yii\mail\MailerInterface $mailer = null)
	{
		$this->_mailMessage->send();
		return $this;
	}
	
	public function toString()
	{
		return parent::toString();
	}

}
?>
