// Get sliders and values
const widthSlider = document.getElementById('width');
const heightSlider = document.getElementById('height');
const rotateSlider = document.getElementById('rotate');

const widthValue = document.getElementById('widthValue');
const heightValue = document.getElementById('heightValue');
const rotateValue = document.getElementById('rotateValue');

const block = document.getElementById('block');
const menu = document.getElementById('menu');

let offsetX, offsetY, isDragging = false;

// Update block width
widthSlider.addEventListener('input', function() {
    const width = widthSlider.value;
    widthValue.textContent = width;
    block.style.width = width + 'px';
});

// Update block height
heightSlider.addEventListener('input', function() {
    const height = heightSlider.value;
    heightValue.textContent = height;
    block.style.height = height + 'px';
});

// Update block rotation
rotateSlider.addEventListener('input', function() {
    const rotate = rotateSlider.value;
    rotateValue.textContent = rotate;
    block.style.transform = `rotate(${rotate}deg)`;
});

// Disable dragging when interacting with sliders
document.querySelectorAll('input[type="range"]').forEach(input => {
    input.addEventListener('mousedown', function() {
        menu.setAttribute('draggable', 'false');
    });
    input.addEventListener('mouseup', function() {
        menu.setAttribute('draggable', 'true');
    });
});

// Dragging functionality for menu
menu.addEventListener('dragstart', function(e) {
    if (!isDragging) {
        offsetX = e.offsetX;
        offsetY = e.offsetY;
        isDragging = true;
    }
});

menu.addEventListener('drag', function(e) {
    if (e.clientX === 0 && e.clientY === 0 || !isDragging) return; // Ignore when drag ends or invalid drag
    menu.style.left = `${e.clientX - offsetX}px`;
    menu.style.top = `${e.clientY - offsetY}px`;
});

menu.addEventListener('dragend', function(e) {
    e.preventDefault();
    isDragging = false;
});
