// Функція для відправлення запиту на сервер після натискання кнопки пошуку
function searchBooks() {
    var query = document.getElementById('search').value;

    // Очищаємо старі результати перед новим пошуком
    document.getElementById('results').innerHTML = '';

    // Якщо запит порожній, зупиняємо виконання
    if (query.trim() === '') {
        document.getElementById('loading').style.display = 'none';
        return;
    }

    // Відображаємо індикатор завантаження
    document.getElementById('loading').style.display = 'block';

    // Створюємо XMLHttpRequest об'єкт
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'search.php?search=' + encodeURIComponent(query), true);

    // Обробник події для отримання відповіді від сервера
    xhr.onload = function() {
        if (xhr.status == 200) {
            // Ховаємо індикатор завантаження після отримання результату
            document.getElementById('loading').style.display = 'none';
            // Відображаємо нові результати у блоці результатів
            document.getElementById('results').innerHTML = xhr.responseText;
        } else {
            // Відображаємо повідомлення про помилку
            document.getElementById('results').innerHTML = 'Помилка отримання результату!';
            document.getElementById('loading').style.display = 'none';
        }
    };

    // Надсилаємо запит
    xhr.send();
}
