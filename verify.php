<?php

/*
# Captchino - eye appealing, easy, modular captcha
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# Verifies form data and compares user submitet code to the one stored in session.
# The current structure is only for demo purpose. Change it to your liking.
*/

$email = 	$_GET["email"];
$subject = 	$_GET["subject"];
$text = 	$_GET["text"];
$captcha = 	$_GET["captcha"];

$response = array();
$response['status'] = 'ok';
$response['errors'] = array();

function fail($field = null, $msg = null) {
	global $response;
	
	if(isset($field)) {
		$response['status'] = 'fail';
		$response['errors'][] = array($field, $msg);
	}
	
	//localy reset captchino code
	include('code_generators/random/RandomCode.php');
	$code = RandomCode::getCode();
	$_SESSION['captchino'] = $code;
	
	respond();
}

function respond() {
	global $response;
	echo json_encode($response);
	die();
}

if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
{
	fail('email', 'Invalid e-mail address');
}
if(empty($subject))
{
	fail('subject', 'Subject is required');
}
if(empty($text))
{
	fail('text', 'Message can\'t be empty');
}

session_start();

if(strtolower($captcha) == strtolower($_SESSION['captchino']))
{

	// <<< YOUR CODE HERE !!! >>>
	
	//$to = 'your@email.com';
	//$headers = 'From: '.$email. "\r\n" .
    //'Reply-To: '.$email . "\r\n" .
    //'X-Mailer: PHP/' . phpversion();
	//mail($to, $subject, $text, $headers);
	
	fail();
}
else
{
	fail('captcha', 'Captcha validation failed');
}

?>
