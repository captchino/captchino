<?php

/*
# Captchino - eye appealing, easy, modular captcha
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# Simple dictionary reader, reads dictionary files and returns one word. Word
# dictionaries taken from Scrabble(tm) game rule book.
*/

class Dictionary {

	static function getCode($code_config) {
		if (!isset( $code_config['file'])) {
			return Dictionary::getCodeByLetters($code_config['letters'], $code_config['mixcase']);
		} else {
			return Dictionary::getCodeByFile($code_config['file'], $code_config['mixcase']);
		}
	}

	static function getCodeByLetters($num, $mixcase = false) {
	
		$file = 'code_generators/dictionary/5letter.txt';
		
		switch ($num) {
			case 3:
				$file = 'code_generators/dictionary/3letter.txt';
				break;
			case 4:
				$file = 'code_generators/dictionary/4letter.txt';
				break;
			case 6:
				$file = 'code_generators/dictionary/6letter.txt';
				break;
			case 7:
				$file = 'code_generators/dictionary/7letter.txt';
				break;
			case 8:
				$file = 'code_generators/dictionary/8letter.txt';
				break;
		}
		
		return Dictionary::getCodeByFile($file, $mixcase);
	}
	
	static function getCodeByFile($file = null, $mixcase = false) {
	
		if (!isset($file)) {
			$file = 'code_generators/dictionary/5letter.txt';
		}
		
		$lines = file($file);
		$line = $lines[mt_rand(0,count($lines)-1)];
		$words = explode(' ',$line); //Yaaaay explosion!
		$word = $words[mt_rand(0,count($words)-1)];
		
		if ($mixcase) {
			$code = '';
			for ($i = 0; $i < strlen($word); $i++) { 
				$char = $word[$i];
				if($char=='l') {
					$char = 'L';
				} else if($char=='i') {
					$char = 'i';
				} else {
					if(mt_rand(0,1) == 1) {
						$char = strtoupper($char);
					}
				}
				$code .= $char;
			}
			return $code;
		} else {
			return $word;
		}
	}
}

?>
