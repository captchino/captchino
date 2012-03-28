<?

# CSVConfig reader
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# Primitive 2 column CSV option reader, it maps data in a key > value array

class CSVConfig {

	static function csvRead($file) {
		$flines = file($file);
		$lines = array();
		
		foreach ($flines as $line) {
				if (($line[0] != '#') && (strpos($line,',') > 0)) {
						$lines[] = explode(',', trim($line)); //Yaaaay explosion!
				}
		}
		
		return $lines;
	}

	static function csvToMap($array) {
		$map = array();
		$num = '0123456789';
		for($i = 0; $i < count($array); $i++) {
		
			if (strpos($array[$i][1],';') > 0) {
				$array[$i][1] = explode(';', $array[$i][1]);
				array_pop($array[$i][1]);
			}
		
			$map[$array[$i][0]] = $array[$i][1];
		}
	
		return $map;
	}

	static function loadConfig($file) {
		return CSVConfig::csvToMap(CSVConfig::csvRead($file));
	}
 
}

?>
