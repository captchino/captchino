<?

# Captchino - eye appealing, easy, modular captcha
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# First graphic generator, generates from given code and returns a PNG image, 
# made to be eye apealing. Style can be defined in graphic_config.csv

class Colorful { 

	public $vars = array( 'font' => 'graphic_generators/colorful/FreeSans.ttf',
	'font_size' => 26,
	'alpha' => 30,
	'angle' => 15,
	'strikethrough' => false,
	'noise' => false,
	'wave' => false,
	'colors' => array('#ff0c00','#ffa200','#ffe400','#a2ff00','#00a8ff','#b400ff'),
	'thickness' => 1,
	'lines' => 10,
	'amplitude' => 5,
	'period' => 10,
	'jumpy' => 0.2,
	'letterdist' => 0.7,
	'randomsize' => 0.1);
	
	public function __construct($code, $options = null) {
		
		if(isset($options)) {
			$this->vars = $this->parseOptions($this->vars, $options);
		}
		
		$characters = strlen($code);  
		
    	$height = 2 * $this->vars['font_size'];
		$width = $this->vars['font_size'] * $this->vars['letterdist'] * ($characters + 2);
	
		$image = imagecreatetruecolor($width, $height);
		$this->fillTransparency($image);
	
		$colors = $this->initColors($image, $this->vars['colors'], $this->vars['alpha']);
	
		$this->paintCode($image, $code, $height, $this->vars['font'], $this->vars['font_size'], $this->vars['angle'], $colors, $this->vars['jumpy'], $this->vars['letterdist'], $this->vars['randomsize']);
	
		if ($this->vars['strikethrough']) {
			$this->strikethrough($image, $height, $width, $this->vars['font_size'], $colors);
		}
	
		if ($this->vars['noise']) {
			$this->addNoise($image, $height, $width, $colors, $this->vars['lines'], $this->vars['thickness']);
		}
		
		if ($this->vars['wave']) {
			$image = $this->wave($image, $this->vars['amplitude'], $this->vars['period']);
		}
	
		$this->echoImage($image);             
  	}
	
	function parseOptions($vars, $options) {
		foreach ($options as $key => $value) {
			$vars[$key] = $value;
		}
		return $vars;
	}
	
	function initColors($image, $colors, $alpha) {
		$color_array = array();
		$ralpha = $this->alphaPercent($alpha);
		for ($i = 0; $i < count($colors); $i++) { 
			$rgb = $this->hexcolor2rgb($colors[$i]);
			$color_array[$i] = imagecolorallocatealpha($image, $rgb['r'], $rgb['g'], $rgb['b'], $ralpha);
		}
		return $color_array;
	}
	
	function hexcolor2rgb($hexcolor) {
		$len = strlen($hexcolor);
		$r = 0;
		$g = 0;
		$b = 0;
		
		if(($len == 4)||($len == 7)) {
			$hexcolor = substr($hexcolor, 1, $len);
			$len-=1;
		}
		
		if($len == 3) {
			$r = hexdec($hexcolor[0].$hexcolor[0]);
			$g = hexdec($hexcolor[1].$hexcolor[1]);
			$b = hexdec($hexcolor[2].$hexcolor[2]);
		} else {
			$r = hexdec(substr($hexcolor, 0, 2));
			$g = hexdec(substr($hexcolor, 2, 2));
			$b = hexdec(substr($hexcolor, 4, 2));
		}
		
		return array('r' =>$r, 'g' =>$g, 'b' =>$b);
	}
	
	function fillTransparency($image) {
		$bg_color = imagecolorallocatealpha($image, 0, 0, 0, 127);
		imagesavealpha($image,true);
		imagefill($image, 0, 0, $bg_color);
	}
	
	function alphaPercent($alpha) {
		if ($alpha <= 0) {
			return 0;
		} else if($alpha > 100) {
			return 127;
		} else {
			return round(127 * $alpha/100);
		}
	}	
	
	function strikethrough($image, $height, $width, $font_size, $colors) {
		$col = mt_rand(0,count($colors)-1);
		$this->imagelinethick($image, 0, $height/2, $width, $height/2, $colors[$col], floor($font_size/10));
	}
	
	function addNoise($image, $height, $width, $colors, $lines, $thickness) {
		for( $i=0; $i<$lines; $i++ ) {
			$col = mt_rand(0,count($colors)-1);
			$this->imagelinethick($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $colors[$col], $thickness);
		}
	}	
	
	function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1) {
		if ($thick == 1) {
			return imageline($image, $x1, $y1, $x2, $y2, $color);
		}
		$t = $thick / 2 - 0.5;
		if ($x1 == $x2 || $y1 == $y2) {
			return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
		}
		$k = ($y2 - $y1) / ($x2 - $x1);
		$a = $t / sqrt(1 + pow($k, 2));
		$points = array(
			round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
			round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
			round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
			round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
		);
		imagefilledpolygon($image, $points, 4, $color);
		return imagepolygon($image, $points, 4, $color);
	}

	function paintCode($image, $code, $height, $font, $font_size, $angle, $colors, $jumpy, $letterdist, $randomsize) {
		for ($i = 0; $i < strlen($code); $i++) {
			$rangle = mt_rand(-$angle, $angle);
			$fontsizemod = round($font_size*$randomsize);
			$size = $font_size + mt_rand(-$fontsizemod, $fontsizemod);
			$dimensions = imagettfbbox($size, $rangle, $font, $code[$i]);
			$fontymod = round($font_size*$jumpy);
			$y = mt_rand(-$fontymod, $fontymod) + ($height - $dimensions[5])/2;
			$x = ($font_size*$letterdist)*($i+$letterdist);
			$col = mt_rand(0,count($colors)-1);
			imagettftext($image, $size, $rangle , $x, $y, $colors[$col], $font , $code[$i]);
		}
	}
	
	 function wave($image, $amplitude, $period) {
	 	
	 	$width = imagesx($image);
	 	$height = imagesy($image);
        $img_dest = imagecreatetruecolor($width, $height);
        $this->fillTransparency($img_dest);
		
		$sign = 1;
		if (mt_rand(0,1) == 1) {
			$sign = -1;
		}
		
		for ($i = 0; $i < $width; $i++) {
			imagecopy($img_dest, $image,
				$i , $sign * $amplitude * sin($i / $period), $i, 0, 1, $height);
		}
        
       	return $img_dest;
    }
	
	function echoImage($image) {
		header('Content-Type: image/png');
		imagepng($image);
		imagedestroy($image);
	}
}

?>
