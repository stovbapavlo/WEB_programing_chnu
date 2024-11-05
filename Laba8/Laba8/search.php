<?php
// Спочатку перевіряємо, чи є переданий пошуковий запит
$query = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($query)) {
    // Формуємо URL для запиту до Open Library
    $search_url = "https://openlibrary.org/search.json?q=" . urlencode($query);

    // Використовуємо file_get_contents для отримання результатів у форматі JSON
    $response = file_get_contents($search_url);

    // Якщо результат порожній, виводимо помилку
    if ($response === FALSE) {
        echo "Не вдалося отримати результат пошуку!";
        exit;
    }

    // Декодуємо JSON-відповідь
    $data = json_decode($response, true);

    // Перевіряємо, чи є результати пошуку
    if (!isset($data['docs']) || empty($data['docs'])) {
        echo "Результати не знайдено для запиту: " . htmlspecialchars($query);
        exit;
    }

    // Формуємо результат у текстовому форматі
    $result = '';
    foreach ($data['docs'] as $book) {
        $title = isset($book['title']) ? $book['title'] : 'Без назви';
        $author = isset($book['author_name'][0]) ? $book['author_name'][0] : 'Невідомий автор';
        $result .= "Назва: " . htmlspecialchars($title) . " | Автор: " . htmlspecialchars($author) . "\n";
    }

    // Виводимо результат
    echo nl2br($result);
} else {
    echo "Введіть запит для пошуку.";
}
?>
