<?php
if (!isset($_GET['city'])) {
    echo "Немає URL";
    exit;
}

$cityCode = $_GET['city'];
$url = "http://www.gismeteo.ua/city/hourly/$cityCode/";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$html = curl_exec($ch);
$city = $data = $sunrise = $sunset = "";
$temperatures = [];
$city = getCity($html);
$cityAndData ="м." . $city .". ".  getData($html);
$sunriseInMinutes = getSunrise($html);
$sunsetInMinutes = getSunset($html);
$temperatures = getTime($html);

$black = imagecreatetruecolor(800, 300);
$left = @imagecreatefrompng('image/left.png');
$center = @imagecreatefrompng('image/center.png');
$right = @imagecreatefrompng('image/right.png');

$rise = round($sunriseInMinutes * 0.5);
$set = round($sunsetInMinutes * 0.5);

imagecopyresized($black, $left, 40 + $rise, 0, 0, 0, 25, 250, 100, 100);
imagecopyresized($black, $center, 40 + 25 + $rise, 0, 0, 0, $set - $rise, 250, 100, 100);
imagecopyresized($black, $right, 40 + $set, 0, 0, 0, 25, 250, 100, 100);

imageline($black, 40, 250, 760, 250, 200);
for ($x_line = 40; $x_line <= 760; $x_line += 90) {
    imageline($black, $x_line, 250, $x_line, 245, 200);
}

$colors = imagecolorexact($black, 0, 0, 255);

$hours = 0;
for ($x_text = 35; $x_text <= 350; $x_text += 90, $hours += 3) {
    imagefttext($black, 16, 0, $x_text, 270, $colors, "C:/Windows/Fonts/Arial.ttf", $hours);
}

for ($x_text = 389; $x_text <= 760; $x_text += 90, $hours += 3) {
    imagefttext($black, 16, 0, $x_text, 270, $colors, "C:/Windows/Fonts/Arial.ttf", $hours);
}

$sun = @imagecreatefrompng('image/sun_sm.png');
$x_center = (800 - 106) / 2;
imagecopyresized($black, $sun, $x_center, 0, 0, 0, 100, 100, 60, 60);

$moon = @imagecreatefrompng('image/moon_sm.png');
imagecopyresized($black, $moon, 50, 0, 0, 0, 100, 100, 63, 63);
imagecopyresized($black, $moon, 650, 0, 0, 0, 100, 100, 63, 63);

$colors = imagecolorexact($black, 255, 255, 255);
imagefttext($black, 15, 0, 300, 290, $colors, "C:/Windows/Fonts/Arial.ttf", $cityAndData);

$colors = imagecolorexact($black, 255, 0, 0);
$minTemp = min($temperatures);
$maxTemp = max($temperatures);

$delta = 140 / ($maxTemp - $minTemp);

for ($i = 0; $i <= 7; $i++) {
    $num_x1 = 40 + $i * 90;
    $num_y1 = 250 - ($temperatures[$i] - $minTemp) * $delta;

    $num_x2 = 40 + ($i + 1) * 90;
    if ($i + 1 < 8) {
        $num_y2 = 250 - ($temperatures[$i + 1] - $minTemp) * $delta;
        imageline($black, round($num_x1), round($num_y1), round($num_x2), round($num_y2), $colors);
    }

    if ($temperatures[$i] > 0) {
        $temperature = '+' . $temperatures[$i];
    } else {
        $temperature = $temperatures[$i];
    }

    imagefttext($black, 16, 0, round($num_x1 - 20), round($num_y1 - 8), $colors, "C:/Windows/Fonts/Arial.ttf", $temperature);
}

imagepng($black);
imagedestroy($black);
curl_close($ch);

function getCity($html){
    if (preg_match('/<meta name="keywords" content="([^"]+)"/u', $html, $matches)) {
        $keywords = $matches[1];
        $keywordsArray = explode(', ', $keywords);
        if (isset($keywordsArray[1])) {
            $keyword = $keywordsArray[1];
        } else {
            $keyword = '';
        }
    
        $searchString = 'погода ';
        $startPosition = strpos($keyword, $searchString);
    
        if ($startPosition !== false) {
            $startPosition += strlen($searchString);
            return trim(substr($keyword, $startPosition));
        }
    }
}

function getData($html){
    if (preg_match('/(\d{4})-(\d{1,2})-(\d{1,2})/', $html, $matches)) {
        $year = $matches[1];
        $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
        $day = str_pad($matches[3], 2, '0', STR_PAD_LEFT);
        return $month .".". $day .".". $year;
    }
}

function getSunrise($html){
    if (preg_match('/Восход — (\d{1,2}:\d{2})<\/div>\s*<div>Заход — (\d{1,2}:\d{2})<\/div>/', $html, $matches)) {
        $sunrise = $matches[1];
    
        list($hours, $minutes) = explode(':', $sunrise);
        $sunriseInMinutes = $hours * 60 + $minutes;
        return $sunriseInMinutes;
    }
}

function getSunset($html){
    if (preg_match('/Восход — (\d{1,2}:\d{2})<\/div>\s*<div>Заход — (\d{1,2}:\d{2})<\/div>/', $html, $matches)) {
        $sunset = $matches[2];
    
        list($hours, $minutes) = explode(':', $sunset);
        $sunsetInMinutes = $hours * 60 + $minutes;
        return $sunsetInMinutes;
    }
}

function getTime($html){
    if (preg_match_all('/<temperature-value value="(.*?)"/u', $html, $matches)) {
        $temperatures = $matches[1];
        $temperatures = array_slice($temperatures, 7, 8);
        return $temperatures;
    }
}
?>