<?

# Captchino - eye appealing, easy, modular captcha
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# A simple random code generator

class RandomCode {
	
	static function getCode($characters = null, $mixcase=false, $charset = null) {
	
		if (!isset($charset)) {
			$charset = '123456789abcdefghijklmnprstvz';
		}
		
		if (!isset($characters)) {
			$characters = 5 ;
		}
	
		$code = '';
		for ($i = 0; $i < $characters; $i++) { 
			$char = $charset[mt_rand(0, strlen($charset)-1)];
			if($mixcase) {
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
