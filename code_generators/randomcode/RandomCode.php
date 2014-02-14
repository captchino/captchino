<?php

/*
# Captchino - eye appealing, easy, modular captcha
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# A simple random code generator
*/

class RandomCode {
	
	static function getCode($code_config) {
		$o = array(
		'letters' => 5,
		'mixcase' => true,
		'charset' => '123456789abcdefghijklmnprstvz');
		
		function parseOptions($vars, $options) {
			foreach ($options as $key => $value) {
				$vars[$key] = $value;
			}
			return $vars;
		}
			
		parseOptions($o, $code_config);
		
		$code = '';
		
		for ($i = 0; $i < $o['letters']; $i++) { 
			$char = $o['charset'][mt_rand(0, strlen($o['charset'])-1)];
			if($o['mixcase']) {
				if($char=='l') {
					$char = 'L';
				} else if($char=='i') {
					$char = 'i';
				} else {
					if(mt_rand(0,1) == 1) {
						$char = strtoupper($char);
					}
				}
			}
			$code .= $char;
		}
		
		return $code;
	}
}

?>
