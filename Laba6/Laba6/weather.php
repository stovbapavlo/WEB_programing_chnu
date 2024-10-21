<?php
$url = 'https://meteofor.com.ua/weather-kharkiv-5053/';
/*https://meteofor.com.ua/weather-kyiv-4944/*/

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
/*curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Accept-Language: uk-UA'
));*/

$out = curl_exec($curl);
curl_close($curl);

$out = mb_convert_encoding($out, 'UTF-8');

if (!$out) {
    die("Не вдалося отримати дані з сайту.");
}

preg_match("/<div class=\"page-title\">(.*?)<\/div>/s", $out, $matches);
if (isset($matches[1])) {
    preg_match("/<h1.*?>(.*?)<\/h1>/", $matches[1], $cityMatch);
    $city = isset($cityMatch[1]) ? $cityMatch[1] : 'Невідоме місто';
} else {
    $city = 'Невідоме місто';
}

echo "<h2>$city</h2>";
echo "<p>Дата: " . date('d.m.Y') . "</p>";

preg_match("/Схід\s*—\s*(\d{2}:\d{2})/su", $out, $sunrise_matches);
$sunrise = isset($sunrise_matches[1]) ? $sunrise_matches[1] : 'Невідомий час сходу';

preg_match("/Захід\s*—\s*(\d{2}:\d{2})/su", $out, $sunset_matches);
$sunset = isset($sunset_matches[1]) ? $sunset_matches[1] : 'Невідомий час заходу';

preg_match("/<div class=\"astro-progress\">\s*Тривалість дня:\s*(\d+\s*год\s*\d+\s*хв)\s*<\/div>/su", $out, $duration_matches);
$duration = isset($duration_matches[1]) ? $duration_matches[1] : 'Невідома тривалість дня';

echo "<p>Схід сонця: $sunrise</p>";
echo "<p>Захід сонця: $sunset</p>";
echo "<p>Тривалість дня: $duration</p>";

preg_match_all("/<div class=\"value\".*?>\s*<temperature-value value=\"(.*?)\" from-unit=\"c\"/su", $out, $temperature_matches);

$temperatures = isset($temperature_matches[1]) ? $temperature_matches[1] : [];

$temperatures = array_slice($temperatures, 4);

$hours = [0, 3, 6, 9, 12, 15, 18, 21];
echo "<h3>Температури на певні години:</h3>";
foreach ($hours as $index => $hour) {
    // Перевіряємо, чи існує значення для відповідної години
    $temperature = isset($temperatures[$index]) ? $temperatures[$index] : 'Невідомо';
    echo "<p>$hour:00 - $temperature °C</p>";
}
?>
