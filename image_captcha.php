<?php
	if(!isset($_SESSION)){
		session_start();
	}
	/**
	 * @author Constantin Boiangiu
	 * @link http://www.php-help.ro
	 * 
	 * This script is provided as-is, with no guarantees.
	 */
	
	/* 
		if you set the session in some configuration or initialization file with
		session id, delete session_start and make a require('init_file.php');
	*/

	/*===============================================================
		General captcha settings
	  ===============================================================*/
	// captcha width
	$captcha_w = 150;
	// captcha height
	$captcha_h = 50;
	// minimum font size; each operation element changes size
	$min_font_size = 12;
	// maximum font size
	$max_font_size = 18;
	// rotation angle
	$angle = 20;
	// background grid size
	$bg_size = 13;
	// path to font - needed to display the operation elements
	$font_path = 'fonts/courbd.ttf';
	
	$postioning = array('1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	
	// array of possible operators
	$operators=$postioning[rand(0,34)];
	// first number random value; keep it lower than $second_num
	$first_num = $postioning[rand(0,34)];
	// second number random value
	$second_num = $postioning[rand(0,34)];
	
	$third_num =  $postioning[rand(0,34)];
	
	$fourth_num = $postioning[rand(0,34)];	
		
	/*===============================================================
		From here on you may leave the code intact unless you want
		or need to make it specific changes. 
	  ===============================================================*/
	
	
	/*
		operation result is stored in $session_var
	*/
	//eval("\$session_var=".$second_num.$operators[0].$first_num.";");
	/* 
		save the operation result in session to make verifications
	*/
	$_SESSION['security_number'] = $first_num.$operators.$second_num.$third_num.$fourth_num;
	/*
		start the captcha image
	*/
	$img = imagecreate( $captcha_w, $captcha_h );
	/*
		Some colors. Text is $black, background is $white, grid is $grey
	*/
	$black = imagecolorallocate($img,0,0,0);
	$white = imagecolorallocate($img,255,255,255);
	$grey = imagecolorallocate($img,215,215,215);
	/*
		make the background white
	*/
	imagefill( $img, 0, 0, $white );	
	/* the background grid lines - vertical lines */
	for ($t = $bg_size; $t<$captcha_w; $t+=$bg_size){
		imageline($img, $t, 0, $t, $captcha_h, $grey);
	}
	/* background grid - horizontal lines */
	for ($t = $bg_size; $t<$captcha_h; $t+=$bg_size){
		imageline($img, 0, $t, $captcha_w, $t, $grey);
	}
	
	/* 
		this determinates the available space for each operation element 
		it's used to position each element on the image so that they don't overlap
	*/
	$item_space = $captcha_w/5;
	
	/* first number */
	imagettftext(
		$img,
		rand(
			$min_font_size,
			$max_font_size
		),
		rand( -$angle , $angle ),
		rand( 10, $item_space-20 ),
		rand( 25, $captcha_h-25 ),
		$black,
		$font_path,
		$first_num);
	
	/*/* operator */
	imagettftext(
		$img,
		rand(
			$min_font_size,
			$max_font_size
		),
		rand( -$angle, $angle ),
		rand( $item_space, 2*$item_space-20 ),
		rand( 25, $captcha_h-25 ),
		$black,
		$font_path,
		$operators);
	
	/* second number */
	imagettftext(
		$img,
		rand(
			$min_font_size,
			$max_font_size
		),
		rand( -$angle, $angle ),
		rand( 2*$item_space, 3*$item_space-20),
		rand( 25, $captcha_h-25 ),
		$black,
		$font_path,
		$second_num);
		
		
		
	/* 3rd number */
	imagettftext(
		$img,
		rand(
			$min_font_size,
			$max_font_size
		),
		rand( -$angle, $angle ),
		rand( 3*$item_space, 4*$item_space-20),
		rand( 25, $captcha_h-25 ),
		$black,
		$font_path,
		$third_num);	
		
		
	/* 4th number */
	imagettftext(
		$img,
		rand(
			$min_font_size,
			$max_font_size
		),
		rand( -$angle, $angle ),
		rand( 4*$item_space, 5*$item_space-20),
		rand( 25, $captcha_h-25 ),
		$black,
		$font_path,
		$fourth_num);	
			
		
		
	/* image is .jpg */
	header("Content-type:image/jpeg");
	/* name is secure.jpg */
	header("Content-Disposition:inline ; filename=securecaptcha.jpg");
	/* output image */
	imagejpeg($img);
?>