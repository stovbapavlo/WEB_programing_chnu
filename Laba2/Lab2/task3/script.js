document.getElementById('input').addEventListener('input', function () {
    const input = this.value.replace(/[^01]/g, ''); // Залишаємо тільки нулі та одиниці
    const grid = document.getElementById('grid');
    grid.innerHTML = '';

    const maxSize = 250;

    for (let i = 0; i < Math.min(input.length, maxSize); i++) {
        const square = document.createElement('div');
        square.classList.add('square');
        if (input[i] === '1') {
            square.classList.add('black');
        } else {
            square.classList.add('white');
        }
        grid.appendChild(square);
    }
});