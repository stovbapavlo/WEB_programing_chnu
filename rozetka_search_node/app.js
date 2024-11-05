const puppeteer = require('puppeteer');
const cheerio = require('cheerio');
const express = require('express');
const app = express();
const PORT = 3000;

// Налаштування для EJS шаблонів
app.set('view engine', 'ejs');
app.set('views', './views');

// Підключення middleware для обробки JSON
app.use(express.json());
app.use(express.static('public')); // Для підключення статичних файлів (наприклад, скриптів)

// Функція для парсингу даних
async function fetchData(searchQuery) {
    try {
        const url = `https://rozetka.com.ua/ua/search/?text=${encodeURIComponent(searchQuery)}`;
        const browser = await puppeteer.launch();
        const page = await browser.newPage();
        await page.goto(url, { waitUntil: 'networkidle2' });
        const data = await page.content();
        const $ = cheerio.load(data);
        const results = [];

        $('.goods-tile').each((index, element) => {
            const title = $(element).find('.goods-tile__title').text().trim();
            const price = $(element).find('.goods-tile__price-value').text().trim();
            const link = $(element).find('.goods-tile__title').attr('href');
            results.push({ title, price, link });
        });

        await browser.close();
        return results;
    } catch (error) {
        console.error('Помилка отримання даних:', error);
        return [];
    }
}

// Основна сторінка
app.get('/', (req, res) => {
    res.render('index');
});

// API маршрут для AJAX-запитів
app.get('/search', async (req, res) => {
    const searchQuery = req.query.search || 'iphone'; // Отримуємо пошуковий запит
    const data = await fetchData(searchQuery); // Парсимо дані
    res.json(data); // Відправляємо результати у форматі JSON
});

// Запуск сервера
app.listen(PORT, () => {
    console.log(`Сервер працює на http://localhost:${PORT}`);
});
