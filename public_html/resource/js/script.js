var menu = document.getElementById('adaptive-menu');
menu.onclick = function() {
    menu.classList.toggle('active');
}
window.onclick = function(e) {
    if (!menu.contains(e.target)) {
        menu.classList.remove('active');
    }
}