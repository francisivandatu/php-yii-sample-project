<?php 
if(!isset($_SESSION))
	session_start();

$active = "contact"; 

class contactUs{

	public $full_name;
	public $your_email;
	public $subject;
	public $message;
	public $vendors;
	public $captcha;
	
	public $errorMessage;
	
	public function validate()
	{
		if ($this->full_name == null)
		{
			$this->errorMessage['full_name'] = 'Full name field cannot be empty.'; 
		}
		
		if ($this->your_email == null)
		{
			$this->errorMessage['your_email'] = 'Your Email field cannot be empty.'; 
		}
		else
		{
			if(!(filter_var($this->your_email, FILTER_VALIDATE_EMAIL)))
			{
				$this->errorMessage['your_email'] = 'Your Email is invalid.'; 
			}
		}
		
		if ($this->subject == null)
		{
			$this->errorMessage['subject'] = 'Subject field cannot be empty.'; 
		}
		
		
			
		if ($this->message == null)
		{
			$this->errorMessage['message'] = 'Message field cannot be empty.'; 
		}
		
		if ($this->vendors == null)
		{
			$this->errorMessage['vendors'] = 'Vendors field cannot be empty.'; 
		}

		// Build POST request:
		$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
		$recaptchaSecret = '6Ld47sUUAAAAAGy08KrLjW1rHSpCybw9TuIwmDmA';
		$recaptchaResponse = $_POST['recaptcha_response'];
		$recaptchaData = array( 'secret' => $recaptchaSecret,
			'response' => $recaptchaResponse
		);
	
		// Make and decode POST request:
		$recaptcha = $this->doPostCUrl($recaptchaUrl, $recaptchaData);

		// Take action based on the score returned:
		if ( !$recaptcha->success || ( isset($recaptcha->score) && $recaptcha->score < 0.5 ) )  
		{
			$this->errorMessage['reCAPTCHA'] = "Invalid reCAPTCHA.";
		}
		
		if(empty($this->errorMessage))
			return true;
		else
			return false;
				
	}

	/**
	 * 
	 * CUrl POST
	 * 
	 * @param Array $data Data to post
	 * @param String $url Url to post
	 * @return object response
	 */
	public function doPostCUrl($url, $data)
	{

		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, $url);
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($verify);

		return json_decode($response);
	}
}

$contactUs = new contactUs;
$flashMessage = '';
	
	if(isset($_GET['success']))
	{
		$flashMessage = '<div class="alert alert-success">You have successfully submitted the form.</div>';
	}
	
	if(isset($_POST['contactUs']))
	{
		foreach($_POST['contactUs'] as $key => $value)
		{
				$contactUs->{$key} = trim($value);
		}
		
		/* validate */
		if($contactUs->validate())
		{
			require_once('swift/lib/swift_required.php');	
			
			//$to = 'francisd@zeniark.com';
			// $to = 'markj.zeniark@gmail.com';
			// $to = array('reynana.zeniark@gmail.com');
			$to = array('rob@essexfunding.com', 'rnewgen@gmail.com', 'bob@essexfunding.com');
			$from = "noreply@essexfunding.com";
			
			$msg = '';
			$msg .='Someone has sent us a message through the contact us page';
			$msg .= '
				<table> 
					<tbody>
					<tr><td>Full Name: </td><td>'.$contactUs->full_name.'</td></tr>
					<tr><td>Your_email: </td><td>'.$contactUs->your_email.'</td></tr>
					<tr><td>Subject: </td><td align="left" colspan="3">'.$contactUs->subject.'</td></tr>
					<tr><td>Message: </td><td align="left" colspan="3">'.$contactUs->message.'</td></tr>				
					<tr><td>Vendors: </td><td align="left" colspan="3">'.$contactUs->vendors.'</td></tr>				
					</tbody>
				</table>'
					;

			$transport = Swift_MailTransport::newInstance();
			//Create the Mailer using your created Transport
			$mailer = Swift_Mailer::newInstance($transport);
			
			//Create the message
			$message = Swift_Message::newInstance()
			//Give the message a subject
			->setSubject('Essex Funding (Contact-Us)')
			
			//Set the From address with an associative array
			->setFrom(array($from))
			
			//Set the To addresses with an associative array
			->setTo($to)
			//->setTo(array("roseann.zeniark@gmail.com","rochelleb.zeniark@gmail.com", "gracem.zeniark@gmail.com"))
			
			//Give it a body
			->setBody($msg, 'text/html');
			
			//Send the message                                    
			$result = $mailer->send($message);
			
			
			if($result){
				header('Location: '.$_SERVER['PHP_SELF'].'?success=1');
				die;
			}else{
				$flashMessage = '<div class="alert alert-danger">An error occurred while sending your form.</div>';
			}
				
		}
		else
		{ 
			$flashMessage = '<div class="alert alert-danger">';
			foreach($contactUs->errorMessage as $error => $message)
			{
				$flashMessage .= "<span>".$message."</span><br/>";
			}
			$flashMessage .= '</div>'; 
		}
			
	}

include('includes/header2.php'); ?>


<script src="https://www.google.com/recaptcha/api.js?render=6Ld47sUUAAAAACqHlGtCmpPuvA7X858kjpKCwn9C"></script>
<script>
	grecaptcha.ready(function() {
		grecaptcha.execute('6Ld47sUUAAAAACqHlGtCmpPuvA7X858kjpKCwn9C', {action: 'contact'}).then(function(token) {
			var recaptchaResponse = document.getElementById('recaptchaResponse');
			recaptchaResponse.value = token;
		});
	});
</script>

	<div class="container content-banner">
		<div class="row">
			<img alt="First slide" src="images/contactus_banner3.jpg" class="img-responsive">
			
		</div>
	</div>
	<div class="container content-container">
		<div class="row">
			
			<div class="col-md-12">
				<h2 class="title">Contact Us</h2>
				<p>To learn more about our leasing programs, please fill out the form below or call us at (813)443-4632.</p>
				<br />
			</div>
			<div class="col-md-6">
				<form action="" method="POST" role="form">
					<div class="form-group">
						<?php echo $flashMessage; ?>
					</div>
					<div class="form-group">
						<label>Full Name</label>
						<input name="contactUs[full_name]" value="<?php echo $contactUs->full_name; ?>"  class="form-control" placeholder="Enter Full Name">
					</div>
					<div class="form-group">
						<label>Your Email</label>
						<input  name="contactUs[your_email]" value="<?php echo $contactUs->your_email; ?>" type="email" class="form-control" placeholder="Enter Email Address">
					</div>
					<div class="form-group">
						<label>Subject</label>
						<input  name="contactUs[subject]" value="<?php echo $contactUs->subject; ?>" class="form-control" placeholder="Enter Subject">
					</div>
					<div class="form-group">
						<label>Message</label>
						<textarea name="contactUs[message]" rows="10" cols="100" class="form-control" placeholder="Message"><?php echo $contactUs->message; ?></textarea>
					</div>
					<div class="form-group">
						<label>Vendors:</label>
						<input  name="contactUs[vendors]" value="<?php echo $contactUs->vendors; ?>" class="form-control" placeholder="Indicate type of equipment you sell">
					</div>
					
					<div class="form-group">
						<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
					</div>
					
					<br />
					<input type="submit" class="btn btn-primary orange-btn" value="Send" />
				</form>

			</div>
		</div>
	</div>
	
<?php include('includes/footer.php'); ?>