<?php
session_start();
// Engedélyezett karakterek
$permitted_chars = '.';

// Véletlenszerű karakterlánc generálása
function generate_string($input, $strength = 5) {
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_string .= $input[mt_rand(0, $input_length - 1)];
    }
    return $random_string;
}

// CAPTCHA szöveg generálása
$string_length = 5;
$captcha_string = generate_string($permitted_chars, $string_length);

// Tároljuk a szöveget a munkamenetben
$_SESSION['captcha_text'] = $captcha_string;

// Kép létrehozása
$image = imagecreatetruecolor(300, 300);

// Színek előállítása
$background_color = imagecolorallocate($image, 33,159,255);
$text_color = imagecolorallocate($image, 255,255,255);
$red_color = imagecolorallocate($image, 128, 0, 0);  // Bordó szín

// Háttér kitöltése
imagefill($image, 0, 0, $background_color);

// Fehér pöttyök elhelyezése véletlenszerűen
for ($i = 0; $i < 5; $i++) {
    $x = rand(10, 290); // X koordináta (a pöttyek nem léphetnek ki a vászonról)
    $y = rand(10, 290); // Y koordináta
    imagefilledellipse($image, $x, $y, 7, 7, $text_color); // Pötty rajzolása
}

// Bordó pötty a pálya közepén
imagefilledellipse($image, 150, 150, 7, 7, $red_color); // Pötty középen


// Kép megjelenítése
header('Content-type: image/png');
imagepng($image);

// Takarítás
imagedestroy($image);
?>
