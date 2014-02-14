<?php

/*
# Captchino - eye appealing, easy, modular captcha
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# Parses configuration files and load modules. Generates captcha code and returns
# captcha image.
# For module development use current modules as a guideline.
*/

class Captchino {
	
	function __construct($var, $cfg, $gcfg, $ccfg) {
		include('utils/CSVConfig.php');
		
		session_start();
	
		$config = CSVConfig::loadConfig($cfg);
		$graphic_config = CSVConfig::loadConfig($gcfg);
		$code_config = CSVConfig::loadConfig($ccfg);

		include('code_generators/'.strtolower($config['code']).'/'.$config['code'].'.php');
		$code = $config['code']::getCode($code_config);

		include('graphic_generators/'.strtolower($config['graphic']).'/'.$config['graphic'].'.php');
		new $config['graphic']($code, $graphic_config);
		
		$_SESSION[$var] = $code;
	}
}

?>
