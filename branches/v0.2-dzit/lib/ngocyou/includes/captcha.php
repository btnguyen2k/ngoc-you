<?php
include_once 'denyDirectInclude.php';
define('SESSION_CAPTCHA', 'CAPTCHA');

function captchaGetImage($width=64, $height=32, $key) {
    $font = 'includes/monofont.ttf';
    $code = captchaGetCode($key);
    if ( $code === NULL ) {
        $code = "ERROR!";
    }
    
    /*
     * Original code: http://www.white-hat-web-design.co.uk/articles/php-captcha.php
     * Improved by NBThanh
     */
    $fontSize = $height * 0.75;
    $image = imageCreate($width, $height) or die("Cannot initialize new GD image stream");
    //set up colors
    $colorBackground = imageColorAllocate($image, 255, 255, 255);
    $colorText       = imageColorAllocate($image, 20, 40, 100);
    $colorNoise      = imageColorAllocate($image, 100, 120, 180);
    // generate random dots in background
    for( $i = 0; $i < ($width*$height)/3; $i++ ) {
        imageFilledEllipse($image, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $colorNoise);
    }
    // generate random lines in background
    for( $i = 0; $i < ($width*$height)/150; $i++ ) {
        imageLine($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $colorNoise);
    }
    // create textbox and add text
    $textbox = imageTtfBbox($fontSize, 0, $font, $code) or die('Error in imageTtfBbox function');
    $x = ($width - $textbox[4])/2;
    $y = ($height - $textbox[5])/2;
    imageTtfText($image, $fontSize, 0, $x, $y, $colorText, $font , $code) or die('Error in imageTtfText function');
    
    return $image;

}

function captchaCreate($key) {
    if ( !isset($_SESSION[SESSION_CAPTCHA]) || !is_array($_SESSION[SESSION_CAPTCHA]) ) {
        $_SESSION[SESSION_CAPTCHA] = Array();
    }
    $code = captchaGenerateCode(4);
    $_SESSION[SESSION_CAPTCHA][$key] = $code;
}

function captchaDelete($key) {
    if ( !isset($_SESSION[SESSION_CAPTCHA]) || !is_array($_SESSION[SESSION_CAPTCHA]) ) {
        $_SESSION[SESSION_CAPTCHA] = Array();
    }
    unset($_SESSION[SESSION_CAPTCHA][$key]);
}

function captchaGetCode($key) {
    if ( !isset($_SESSION[SESSION_CAPTCHA]) || !is_array($_SESSION[SESSION_CAPTCHA]) ) {
        $_SESSION[SESSION_CAPTCHA] = Array();
    }
    return isset($_SESSION[SESSION_CAPTCHA][$key]) ? $_SESSION[SESSION_CAPTCHA][$key] : NULL;
}

function captchaGenerateCode($len=4) {
    /* list all possible characters, similar looking characters and vowels have been removed */
    $possible = '23456789bcdfghjkmnpqrstvwxyz';
    $code = '';
    $i = 0;
    while ( $i < $len ) {
        $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
        $i++;
    }
    return $code;
}
?>