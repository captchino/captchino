<?php
include('Captchino.php');
/*
 * THIS IS HOW WE ROLL!
 *
 * First parameter should be name of a variable in session where you will keep your generated code, second variable is captchino config csv uri where you define code and image generators to be used, third parameter is a local uri of a graphic generator config file and last param is code henerator configuration csv file uri!
 */
new Captchino('captchino','config.csv', 'graphic_config.csv', 'code_config.csv');
?>
