// src/components/Search.js
import React, { useState } from 'react';
import axios from 'axios';
import './Search.css';
import Loader from './Loader'; // Імпортуємо індикатор завантаження

const Search = () => {
    const [searchQuery, setSearchQuery] = useState('');
    const [results, setResults] = useState([]);
    const [loading, setLoading] = useState(false);
    const [typingTimeout, setTypingTimeout] = useState(0);

    const handleInputChange = (event) => {
        const query = event.target.value;
        setSearchQuery(query);

        // Очистити попередній тайм-аут
        if (typingTimeout) {
            clearTimeout(typingTimeout);
        }

        // Встановити новий тайм-аут для виконання пошуку
        setTypingTimeout(
            setTimeout(() => {
                performSearch(query);
            }, 500) // затримка в 500 мс
        );
    };

    const performSearch = async (query) => {
        // Перевірка, чи є в полі введення текст
        if (!query.trim()) {
            setResults([]);
            setLoading(false); // Вимкнення індикатора завантаження, якщо поле пусте
            return;
        }

        setLoading(true);
        try {
            const response = await axios.get(`/search`, {
                params: { search: query },
            });
            setResults(response.data);
        } catch (error) {
            console.error('Помилка отримання даних:', error);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="search-container">
            <h1>Пошук товарів на Rozetka</h1>
            <input
                type="text"
                placeholder="Введіть пошуковий запит"
                value={searchQuery}
                onChange={handleInputChange}
                className="search-input"
            />

            {/* Відображаємо індикатор завантаження тільки тоді, коли введено текст і йде завантаження */}
            {loading && searchQuery.trim() ? (
                <Loader />
            ) : (
                <div className="cards-container">
                    {results.length > 0 ? (
                        results.map((item, index) => (
                            <div key={index} className="card">
                                <a href={item.link} target="_blank" rel="noopener noreferrer">
                                    <img src={item.imageUrl} alt={item.title} className="card-image" />
                                </a>
                                <div className="card-content">
                                    <a href={item.link} target="_blank" rel="noopener noreferrer" className="card-title">
                                        {item.title}
                                    </a>
                                    <p className="card-price">{item.price} грн</p>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p>{loading ? '' : 'Нічого не знайдено'}</p>
                    )}
                </div>
            )}
        </div>
    );
};

export default Search;
