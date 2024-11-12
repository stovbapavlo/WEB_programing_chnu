<?php
$query = isset($_GET['q']) ? urlencode($_GET['q']) : '';
$url = "https://technosell.com.ua/ua/search/?query=$query";

// Використовуємо cURL для отримання HTML
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Додаємо User-Agent
$htmlContent = curl_exec($ch);
curl_close($ch);

if ($htmlContent === false) {
    echo "Помилка отримання даних";
    exit;
}

// Обрізаємо HTML до блоку з результатами пошуку
preg_match('/<div class="search-results">(.+?)<\/div>/s', $htmlContent, $matches);

if (isset($matches[1])) {
    $searchResults = $matches[1];
    echo $searchResults;
} else {
    echo "Результати не знайдені";
}
?>
