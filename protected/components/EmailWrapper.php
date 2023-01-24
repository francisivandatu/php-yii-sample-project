<?php
class EmailWrapper
{
	private $_sender;
	private $_receivers = array("roseann.zeniark@gmail.com","rochelleb.zeniark@gmail.com", "gracem.zeniark@gmail.com");
	private $_bcc = array();
	private $_subject;
	private $_message;
	private $_attachment = null;
	private $_emailType;
	private $_errors;
	
	public function __construct()
	{
		// Load swift mailer library if needed
		if (!defined('SWIFT_LIB_DIRECTORY'))
		{
			$phpExcelPath = Yii::getPathOfAlias('ext.swiftMailer.lib');
			include($phpExcelPath . DIRECTORY_SEPARATOR . 'swift_required.php');
		}

		$this->_sender = array('info@essexfunding.com' => 'Essex Funding');
		$this->_subject = 'Essex';
		$this->_errors = array();
		$this->_emailType = 'text/html';
	}
		
	public function setMessage($message)
	{
		$this->_message = $message;
	}
		
	public function setReceivers($receivers)
	{
		$this->_receivers = $receivers;
		// $this->_receivers = array("roseann.zeniark@gmail.com","rochelleb.zeniark@gmail.com", "gracem.zeniark@gmail.com");
	}
	
	public function setSender($sender)
	{
		$this->_sender = $sender;
	}
	
	public function setBcc( $bcc )
	{
		$this->_bcc = $bcc;
	}
	
	public function setSubject($subject)
	{
		$this->_subject = $subject;
	}
	
	public function setAttachment($attachment)
	{
		$this->_attachment = $attachment;
	}
	
	public function getErrors()
	{
		return $this->_errors;
	}
	
	public function loadTemplate($template = null)
	{
		switch ($template)
		{
			case 'default':
				$templateBody = 
					sprintf('
									<table width="650" cellspacing="0" cellpadding="0" border="0" align="center">
										<tbody>
											<tr>
												%s
											</tr>
										</tbody>
									</table>
					', $this->_message);
				break;
			
			case 'blank':
				$templateBody = $this->_message;
				break;
			
			default:
				$templateBody = 
					sprintf('
									<table width="650" cellspacing="0" cellpadding="0" border="0" align="center">
										<tbody>
											<tr>
												%s
											</tr>
										</tbody>
									</table>
					', $this->_message);
		}
		
		return $templateBody;
	}
	
	public function sendMessage($template = null)
	{
		// return true;
		$this->validateAttributes();
		
		if (empty($this->_errors))
		{
				// $transport = Swift_SmtpTransport::newInstance('localhost', 25);
				$transport = Swift_SmtpTransport::newInstance('smtpout.secureserver.net', 25)
					->setUsername('info1@zaccessdomain.com')
					->setPassword('12345')
				;
				$mailer = Swift_Mailer::newInstance($transport);
				
				$message = Swift_Message::newInstance()
					->setSubject($this->_subject)
					->setFrom($this->_sender)
					->setTo($this->_receivers)
					->setBcc($this->_bcc)
					->setBody($this->loadTemplate($template), $this->_emailType);
				
				if(!empty($this->_attachment))
					$message->attach(Swift_Attachment::fromPath($this->_attachment));

				if ($mailer->send($message))
				{
					return true;
				}
				else
				{
					$this->_errors[] = 'Sorry but an error has occurred processing the email message';
					
					return false;
				}
		}
		else
		{
			return false;
		}
	}
	
	public function validateAttributes()
	{
		if ($this->_receivers === null || empty($this->_receivers))
		{
			$this->_errors[] = 'Please set at least 1 receiver';
		}
		
		if ($this->_message === null)
		{
			$this->_errors[] = 'Please enter a message for the email';
		}
	}
}
?>
