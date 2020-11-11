// document.addEventListener("DOMContentLoaded", function(e) {
//
//     // document.onmousedown = function () {
//     //     timerIncrement();
//     // };
//     document.onsubmit = function () {
//         timerIncrement();
//     };
// });
//
// function timerIncrement() {
//
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', '/');
//     xhr.send();
// }

let btn = document.querySelector('.drop-btn');
let drop = document.querySelector('.drop-menu');
btn.addEventListener("click", function(){
    drop.classList.toggle("active");
}, false);
