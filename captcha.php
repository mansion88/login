<?php
require_once 'Text/CAPTCHA.php';

// Set CAPTCHA options (font must exist!)
$imageOptions = array(
    'font_size'        => 24,
    'font_path'        => './',
    'font_file'        => 'COUR.TTF',
    'text_color'       => '#DDFF99',
    'lines_color'      => '#CCEEDD',
    'background_color' => '#555555'
);

// Set CAPTCHA options
$options = array(
    'width' => 200,
    'height' => 80,
    'output' => 'png',
    'imageOptions' => $imageOptions
);
           
// Generate a new Text_CAPTCHA object, Image driver
$c = Text_CAPTCHA::factory('Image');
$retval = $c->init($options);
if (PEAR::isError($retval)) {
    printf('Error initializing CAPTCHA: %s!',
        $retval->getMessage());
    exit;
}

// Get CAPTCHA secret passphrase
$_SESSION['phrase'] = $c->getPhrase();

// Get CAPTCHA image (as PNG)
$png = $c->getCAPTCHAAsPNG();
if (PEAR::isError($png)) {
    echo 'Error generating CAPTCHA!';
    echo $png->getMessage();
    exit;
}
file_put_contents(md5(session_id()) . '.png', $png);
?>
