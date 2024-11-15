// backend/index.js
const puppeteer = require('puppeteer');
const cheerio = require('cheerio');
const express = require('express');
const cors = require('cors'); //мідлвар
const app = express();
const PORT = 5000;

app.use(cors()); // дозволяємо запити з фронтенду

async function fetchData(searchQuery) {
    const url = `https://rozetka.com.ua/ua/search/?text=${encodeURIComponent(searchQuery)}`;
    let browser;

    try {
        browser = await puppeteer.launch({
            headless: true,
            args: ['--no-sandbox', '--disable-setuid-sandbox'],
        });
        const page = await browser.newPage();

        // User-Agent
        await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

        await page.goto(url, { waitUntil: 'domcontentloaded' });
        await page.waitForSelector('.goods-tile');

        const data = await page.content();
        const $ = cheerio.load(data);
        const results = [];

        $('.goods-tile').each((index, element) => {
            const title = $(element).find('.goods-tile__title').text().trim();
            const price = $(element).find('.goods-tile__price-value').text().trim();
            const link = $(element).find('.goods-tile__title').attr('href');

            // Отримуємо URL зображення напряму з атрибуту 'src'
            const imageUrl = $(element).find('.goods-tile__picture img').attr('src');

            results.push({ title, price, link, imageUrl });
        });

        return results;
    } catch (error) {
        console.error('Помилка отримання даних:', error);
        return [];
    } finally {
        if (browser) {
            await browser.close();
        }
    }
}

app.get('/search', async (req, res) => {
    const searchQuery = req.query.search || 'iphone';
    const data = await fetchData(searchQuery);
    res.json(data);
});

app.listen(PORT, () => {
    console.log(`Сервер працює на http://localhost:${PORT}`);
});
