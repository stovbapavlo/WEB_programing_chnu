const toRightBtn = document.getElementById('toRight');
const toLeftBtn = document.getElementById('toLeft');
const list1 = document.getElementById('list1');
const list2 = document.getElementById('list2');

function moveItems(sourceList, targetList) {
    const selectedItems = [...sourceList.querySelectorAll('input:checked')];

    selectedItems.forEach(item => {
        const li = item.closest('li');

        const value = li.textContent.trim();

        const listItems = [...targetList.children]
        let inserted = false;

        for (let i = 0; i < listItems.length; i++) {
            if (value < listItems[i].textContent.trim()) {
                targetList.insertBefore(li, listItems[i]);
                inserted = true;
                break;
            }
        }

        if (!inserted) {
            targetList.appendChild(li);
        }

        item.checked = false;
    });
}

toRightBtn.addEventListener('click', () => {
    moveItems(list1, list2);
});

toLeftBtn.addEventListener('click', () => {
    moveItems(list2, list1);
});
