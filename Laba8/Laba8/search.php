<?php
// Перевіряємо, чи переданий параметр "query" у GET-запиті
if (isset($_GET['query'])) {
    // Отримуємо пошуковий запит
    $query = $_GET['query'];

    // Формуємо URL сторінки пошуку на Rozetka з динамічним пошуком
    $search_url = "https://rozetka.com.ua/ua/mobile-phones/c80003/preset=smartfon/#search_text=" . urlencode($query);

    // Ініціалізація cURL
    $ch = curl_init();

    // Налаштування cURL
    curl_setopt($ch, CURLOPT_URL, $search_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // Виконання запиту
    $response = curl_exec($ch);

    // Перевірка на помилки
    if ($response === FALSE) {
        echo "Не вдалося отримати дані!";
        curl_close($ch);
        exit;
    }

    // Закриття cURL
    curl_close($ch);

    // Використовуємо DOMDocument для парсингу HTML
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();

    // Використовуємо XPath для пошуку блоку з товарами
    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query("//*[contains(@class, 'catalog-grid')]");

    // Виводимо результати
    if ($nodes->length > 0) {
        foreach ($nodes as $node) {
            echo $dom->saveHTML($node);
        }
    } else {
        echo "Товари за вашим запитом не знайдено.";
    }
} else {
    echo "Будь ласка, введіть запит для пошуку.";
}
?>
