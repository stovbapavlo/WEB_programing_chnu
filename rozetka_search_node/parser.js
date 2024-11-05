const axios = require('axios');
const cheerio = require('cheerio');

async function fetchData() {
    try {
        const url = 'https://rozetka.com.ua/ua/search/?text=iphone';
        const { data } = await axios.get(url);

        const $ = cheerio.load(data);

        const results = [];

        $('.goods-tile').each((index, element) => {
            const title = $(element).find('.goods-tile__title').text().trim();
            const price = $(element).find('.goods-tile__price-value').text().trim();
            const link = $(element).find('.goods-tile__title').attr('href');

            results.push({ title, price, link });
        });

        console.log(results);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

fetchData();
