let request_form = document.forms[0];
let msg__block = document.querySelector('.msg__block');

if (document.forms[0]) {
    let url = request_form.action;

    function valid_inputs(elem) {
        let formData = new FormData();
        formData.append('name', elem.getAttribute('name'));
        formData.append('value', elem.value);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.send(formData);

        xhr.onload = function() {
            let data = JSON.parse(xhr.responseText);
            let obj = document.querySelector('[name="' + data['object'] + '"]');
            if (xhr.readyState === 4) {

                if (xhr.status === 400 && data['status'] === 'invalid-input') {

                    ErrorState('[name="' + data['object'] + '"]');
                    obj.nextElementSibling.textContent = data['message'];
                    msg__block.classList.add('alert-danger');

                }
                if (xhr.status === 200 && data['status'] === 'valid') {
                    obj.parentElement.classList.remove('error');
                    obj.nextElementSibling.classList.remove('invalid');
                    obj.parentElement.classList.add('regular');
                    obj.nextElementSibling.classList.add('valid');
                    obj.nextElementSibling.textContent = data['message'];
                    close();
                }
                if (data['status'] === 'empty') {
                    obj.nextElementSibling.textContent = data['message'];
                    obj.parentElement.classList.remove('error');
                    obj.nextElementSibling.classList.remove('invalid');
                    obj.parentElement.classList.remove('regular');
                    obj.nextElementSibling.classList.remove('valid');
                    close();
                }
            }
        }
        xhr.onerror = function() {
            alert(`Ошибка соединения`);
        };


    };
}
let input = document.querySelectorAll('.input-select select,.input-wrap input, textarea');
input.forEach(elem => {
    elem.addEventListener("input", debounce(function() {
        valid_inputs(elem);
    }, 1250, false), false);
});

function debounce(func, wait, immediate) { //ограничение скорости функции
    let timeout;

    return function executedFunction() {
        const context = this;
        const args = arguments;

        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };

        const callNow = immediate && !timeout;

        clearTimeout(timeout);

        timeout = setTimeout(later, wait);

        if (callNow) func.apply(context, args);
    };
};