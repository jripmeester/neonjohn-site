<?php
date_default_timezone_set('Europe/Amsterdam');

$bResult = FALSE;

if(	isset($_POST['name']) && !empty($_POST['name']) && 
	isset($_POST['email']) && !empty($_POST['email']) &&
	isset($_POST['secureCode']) && $_POST['secureCode'] === 'neonJohnSecureCode80sItalo'
	) {

	// BUILD MESSAGE
	$sInformation = '
	<b>Name: </b> '.$_POST['name'].'<br />
	<b>Email: </b> '.$_POST['email'].'<br />';
	if(isset($_POST['phone']) && !empty($_POST['phone'])) {
		$sInformation .= '<b>Phonenumber: </b> '.$_POST['phone'].'<br />';
	}
	if(isset($_POST['message']) && !empty($_POST['message'])) {
		$sInformation .= '<b>Your message: </b> '.$_POST['message'].'<br />';
	}

	
	$sUserMessage = '
	<h1>Dear '.$_POST['name'].', we would like to thank you for your brilliant taste of music!</h1>
	<p>The world needs more people like you, as do we. And with this inquiry you did humanity a big favor in sharing your taste of music on your party.</p>
	<p>Below you can find the information as we received it from you:</p>
	'.$sInformation.'
	<p>We\'ll contact you as soon as possible!<br />
	Untill then be sure to check our <a href="http://soundcloud.com/neonjohnmusic">soundcloud</a> for your daily dose of Neon.</p>
	<p>Grazie mille,<br />
	NJ</p>';

	$sNJMessage = '
	<h1>New booking alarm!</h1>
	'.$sInformation.'
	<p>Grazie mille,<br />
	NJ website</p>';

	require_once $_SERVER['DOCUMENT_ROOT'].'/../classes/lib/swift_required.php';

	$transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587)
	  ->setUsername('info@getloops.nl')
	  ->setPassword('d8d9e7cf-ca8e-4c5a-92fa-6100b798f8b6')
	  ;

  	$mailer = Swift_Mailer::newInstance($transport);

	// Create the message
	$message = Swift_Message::newInstance()

	  // Give the message a subject
	  ->setSubject('Website booking')

	  // Set the From address with an associative array
	  ->setFrom(array('info@neonjohn.net' => 'Neon John'))

	  // Set the To addresses with an associative array
	  ->setTo(array('john@neonjohn.net'))

	  // Give it a body
	  ->setBody(strip_tags($sNJMessage))

	  // And optionally an alternative body
	  ->addPart($sNJMessage, 'text/html')
	  ;

	$aNJResult = $mailer->send($message);

	if($aNJResult === 1) {
		unset($mailer);
		unset($message);
		$mailer = Swift_Mailer::newInstance($transport);

		// Create the message
		$message = Swift_Message::newInstance()

		  // Give the message a subject
		  ->setSubject('Your Neon request confirmation')

		  // Set the From address with an associative array
		  ->setFrom(array('info@neonjohn.net' => 'Neon John'))

		  // Set the To addresses with an associative array
		  ->setTo(array($_POST['email'] => $_POST['name']))

		  // Give it a body
		  ->setBody(strip_tags($sUserMessage))

		  // And optionally an alternative body
		  ->addPart($sUserMessage, 'text/html')
		  ;

		$aVisitorResult = $mailer->send($message);

		if($aVisitorResult === 1) {
			$bResult = TRUE;
		}
	}
}
$aResponse = array('succes' => $bResult);
echo json_encode($aResponse);

