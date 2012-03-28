<?php

# Captchino - eye appealing, easy, modular captcha
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# Verifies form data and compares user submitet code to the one stored in session.
# The current structure is only for demo purpose. Change it to your liking.

$email = 	$_GET["email"];
$subject = 	$_GET["subject"];
$text = 	$_GET["text"];
$captcha = 	$_GET["captcha"];

$response = array();
$response['status'] = 'ok';
$response['errors'] = array();

if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$response['status'] = 'fail';
	$response['errors'][] = array('email', 'Invalid e-mail address');
}
if(empty($subject))
{
	$response['status'] = 'fail';
	$response['errors'][] =  array('subject', 'Subject is required');
}
if(empty($text))
{
	$response['status'] = 'fail';
	$response['errors'][] =  array('text', 'Message can\'t be empty');
}

session_start();

if(strtolower($captcha) == strtolower($_SESSION['captchino']))
{
	//$to = 'your@email.com';
	//mail($to, $subject, $text);
}
else
{
	$response['status'] = 'fail';
	$response['errors'][] =  array('captcha', 'Captcha validation failed');
}



echo json_encode($response);
?>
