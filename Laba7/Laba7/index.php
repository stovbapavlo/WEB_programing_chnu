<?php
// Місто, яке буде виводитися на зображенні
$city = 'Київ';

// Створюємо зображення 500x200 пікселів
$im = imagecreatetruecolor(500, 200);

// Включаємо антиалайзінг для згладжування ліній
imageantialias($im, true);

// Чорний та зелений кольори
$black = imagecolorallocate($im, 0x00, 0x00, 0x00);
$green = imagecolorallocate($im, 0x00, 0xFF, 0x00);

// Заливаємо зображення чорним кольором
imagefilledrectangle($im, 0, 0, 499, 199, $black);

// Шрифт (переконайтеся, що шлях до шрифту правильний)
$font_file = 'fonts/Roboto-Regular.ttf';

// Виводимо текст на зображення (місто Київ)
imagefttext($im, 20, 0, 100, 55, $green, $font_file, "Місто: $city");

// Завантажуємо зображення із файлів і копіюємо на основне зображення
$leftImage = imagecreatefrompng('assets/left.png');
$centerImage = imagecreatefrompng('assets/center.png');
$rightImage = imagecreatefrompng('assets/right.png');

// Копіюємо зображення на основне зображення
imagecopy($im, $leftImage, 0, 100, 0, 0, 166, 100);
imagecopy($im, $centerImage, 166, 100, 0, 0, 166, 100);
imagecopy($im, $rightImage, 332, 100, 0, 0, 166, 100);

// "Магічні" дії для виведення зображення
header('Content-Type: image/png');
imagepng($im);

// Очищуємо пам'ять
imagedestroy($im);
imagedestroy($leftImage);
imagedestroy($centerImage);
imagedestroy($rightImage);
?>
