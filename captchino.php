<?php

# Captchino - eye appealing, easy, modular captcha
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# Parses configuration files and load modules. Generates captcha code and returns
# captcha image.
# For module development use current modules as a guideline.

include('utils/CSVConfig.php');

session_start();

$config = CSVConfig::loadConfig('config.csv');

$graphic_config = CSVConfig::loadConfig('graphic_config.csv');
$code_config = CSVConfig::loadConfig('code_config.csv');

if (isset($_GET['size']))
	$graphic_config['font_size'] = intval($_GET['size']);

if ($config['code'] == 'random') {
	include('code_generators/random/RandomCode.php');
	if (!isset( $code_config['charset'])) {
		$code_config['charset'] = null;
	}
	$code = RandomCode::getCode($code_config['letters'], $code_config['mixcase'], $code_config['charset']);
}

if ($config['code'] == 'dictionary') {
	include('code_generators/dictionary/Dictionary.php');
	if (!isset( $code_config['file'])) {
		$code = Dictionary::getCodeByLetters($code_config['letters'], $code_config['mixcase']);
	} else {
		$code = Dictionary::getCode($code_config['file'], $code_config['mixcase']);
	}
	
}

if ($config['graphic'] == 'colorful') {
	include('graphic_generators/colorful/Colorful.php');
	$captcha = new Colorful($code, $graphic_config);
}

$_SESSION['captchino'] = $code;

?>
