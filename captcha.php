<?php
  $image = @imagecreatetruecolor(120, 30);

  // set background color and set drawing colors
  $background = imagecolorallocate($image, 250, 250, 250);
  imagefill($image, 0, 0, $background);
  $linecolor = imagecolorallocate($image, 23, 88, 211);
  $textcolor = imagecolorallocate($image, 39, 36, 36);

  // draw random lines on canvas
  for ($i=0; $i < 4; $i++) {
      imagesetthickness($image, rand(1, 2));
      imageline($image, 0, rand(0, 30), 120, rand(0, 30), $linecolor);
  }

  session_start();

  // add random digits to canvas
  $digit = '';
  for ($x = 15; $x <= 95; $x += 20) {
      $digit .= ($num = rand(0, 9));
      imagechar($image, rand(3, 5), $x, rand(2, 14), $num, $textcolor);
  }

  // set digit in session to be able to check if correct input was given by user
  $_SESSION['digit'] = $digit;

  // display image and destroy so you always create new captcha
  header('Content-type: image/png');
  imagepng($image);
  imagedestroy($image);
