const box =document.getElementById("box");
const coords = document.getElementById("coords");

box.addEventListener('mousemove', (e) =>{
    const rect = box.getBoundingClientRect();
    const x = Math.floor(e.clientX - rect.left);
    const y = Math.floor(e.clientY - rect.top);

    coords.textContent = `x=${x},y=${y}`;

})