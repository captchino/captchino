Captchino 
=========
"eye appealing, simple, modular PHP captcha with demo"


What?
-----
An easy to setup captcha system written in PHP that works out of the box.
All parameters are optional, it just works. Feel free to supply optional 
parameters to tweak it to your liking. NO PHP KNOWLEDGE REQUIRED to operate this
captcha.


Why?
----
But seriously guys, why develop another captcha, there like a ton of them???

We needed a simple captcha for email forms we embed into websites that we develop.
Gave the recaptcha a quick thought but found it too robust for a simple email form.
Then we started searching for a slimple one but soon realized that all of
them were gloomy, unattractive and kinda ruined the design of the site.
And if there is a lot of something it is easy to manufacture thus the philosophy
says. We wanted to do this right, once for all to serve us for years to 
come. And of course share it with anyone who needs it.
So there you have it. An easy to use, highly configurable, expandaple captcha.


How does it work?
-----------------
The code is quite self explanatory, but a bit of doccumentation never hurt anyone.
Let us explain the directory structure and modules of this simple piece of code.

+ root dir
	- captchino.php 		-> outputs the image, generates code
	- verify.php 			-> verifies user submited data and captcha code
	- graphic_config.csv	-> define captcha style here
	- code_config.csv		-> define code generating parameters here
	- config.csv			-> define what generator plugins will you use
	+ code_generators		-> code generating plugins
	+ graphic_generators	-> graphic generating plugins
	+ utils					-> utilities and libraries
	
	~ effect_generators (will be developed in next version)
	~ effect_config.csv

	
# captchino.php
Generates the code, stores it into $_SESSION['captchino'] and outputs a PNG image.
You can call it via ajax or simply insert it into html like <img src="path/captchino.php" />
Or with parameter <img src="path/captchino.php?size=26" />
Only one parameter is allowed through url and that is 'size'. The size defines
the font size and the font size defines image size. You can reduce image size later
on with css. 
Captchino.php this captcha's main class. It combines the code and graphic
generating classes. If you wish to develop a code or a graphic generating plugin
you must add it to the main class. Use already developed plugins as a guideline.


# verify.php
You can put your code inside verify.php just dont forget to check the user submited
captcha code to session stored captcha code

if(strtolower($captcha) == strtolower($_SESSION['captchino'])) {
	//YOUR CODE HERE
}

*Remove strtolower if you want it case sensitive


# graphic_config.csv
Configuration file used to define captcha style. Uncomment the values
and edit them with your data to change the defaults. Every graphic generator
will have different configuration, this example is for the current and only
Colorful.php

	font 					-> path to your Font.ttf
	font_size				-> font size (integer)
	alpha					-> letter transparency (0-100)
	angle					-> letter rottation (0-360)
	strikethrough			-> big line in the middle (true or false)
	noise					-> random line noise (true or false)
	wave					-> sin function distortion (true or false)
	colors					-> hex color array (#ff0c00;#ffa200;#ffe400;)
	thickness				-> noise lines thicknes (integer)
	lines					-> number of random lines (integer)
	amplitude				-> wave amplitude (integer)
	period					-> wave period (integer)
	jumpy					-> random y displacement modifier (float)
	letterdist				-> letter spacing modifier (float)
	randomsize				-> random letter size modifier (float)
	
# code_config.csv
Configuration fille used to apply paramaeter to code generators. Currently there
are only two code generators, random and dictionary, and both take same basic 
parameters.
	
	letter					-> number of letters (integer)
	mixcase					-> random big and small letters (true or false)
	
Random specific parameters
	charset					-> string with available chars / no blankspace (string)
	
Dictionary specific parameters
	file					-> location of your dictionary file (string)
	

# config.csv
Defines the plugins to be used by captchino.php. If you want to change the
graphic generating system or code generating system insert the name of desired
plugin. For instance:

	code,dictionary
	graphic,colorful

then the dictionary code generating system and colorful graphic system will be
activated.

# code_generators and graphic_generators
Are directories for captchino plugins. For developing a plugin use already developed
plugins as a guideline.

DEPENDENCY
----------
GD module!!!


DEMO
----
The demo built for this captcha is a simple email form prettified with Twitter 
Bootstrap (http://twitter.github.com/bootstrap/) and made more fuctional with 
jQuery (http://jquery.com/).
Form.js refreshes captcha by calling captchino.php that returns the captcha image.
On button press submits form data over ajax through parameters in url to verify.php
that checks the submited captcha data to one from the session. It returns array of
errors if the codes mismatch or activates your piece of code.


Bottomline
----------
We really hope that you found this piece of code useful.
THANK YOU FOR GIVING IT A CHANCE. :D


Authors and copyright
---------------------
See AUTHORS and COPYING file for relevant information.



iVar - March 2012.

