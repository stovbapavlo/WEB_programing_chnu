/*
const list1 = document.getElementById('list1');
const list2 = document.getElementById('list2');
*/

const toRightBtn = document.getElementById('toRight');
const toLeftBtn = document.getElementById('toLeft');


const names = [
    'Андрієнко А.Б.',
    'Борисенко В.Г.',
    'Василенко Д.Є.',
    'Гавриленко К.Л.',
    'Дмитренко М.Н.',
    'Клименко В.М.'
];

const list1 = document.getElementById('list1');

function createListItems(names, list) {
    names.forEach(name => {
        const li = document.createElement('li');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.value = name;

        li.appendChild(checkbox);
        li.appendChild(document.createTextNode(` ${name}`));
        list.appendChild(li);
    });
}

createListItems(names, list1);

function moveItems(sourceList, targetList) {
    const selectedItems = [...sourceList.querySelectorAll('input:checked')];

    if (selectedItems.length === 0) {
        alert('Виберіть елементи для переміщення');
        return;
    }

    selectedItems.forEach(item => {
        const li = item.closest('li');
        const value = li.textContent.trim();

        // Додаємо елемент до нового списку
        targetList.appendChild(li);
        item.checked = false;
    });

    sortList(targetList);
}

function sortList(list) {
    const items = [...list.children];
    items.sort((a, b) => a.textContent.trim().localeCompare(b.textContent.trim()));
    items.forEach(item => list.appendChild(item));
}

toRightBtn.addEventListener('click', () => {
    moveItems(list1, list2);
});

toLeftBtn.addEventListener('click', () => {
    moveItems(list2, list1);
});

