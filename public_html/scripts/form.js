let form = document.forms[0];
let url = form.action;
document.addEventListener("DOMContentLoaded", function() {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let elm = document.getElementById('item-cat');
        let types = [];
        if (elm) {
            for (let j = 0; j < elm.options.length; j++) {
                if (elm.options[j].selected)
                    types.push(elm.options[j].value);
            }
            formData.append('item-cat', types);
        }


        let xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.send(formData);
        xhr.onload = function() {
            if (xhr.readyState === 4) {
                let data = JSON.parse(xhr.responseText);
                if (xhr.status === 400 && data['status'] === 400) {
                    alert(data['message']);
                }
                if (data['status'] === 'invalid') {
                    let error_block = document.querySelector('.msg__block');
                    error_block.querySelector('span').innerHTML = data['message'];
                    error_block.classList.add('show');
                    if (data['object'] === 'all')
                        ErrorState('.input-wrap');
                    else {
                        let obj = split(data['object'], ',');
                        let i = 0;
                        while (i < obj.count) {
                            ErrorState('[name="' + obj.arr[i] + '"]');
                            i++;
                        }
                    }
                }
                if(data['status'] === 'valid') {
                    remove_selector('.error');
                    remove_selector('.invalid');
                    close();
                }
                if(xhr.status === 200 && data['status'] === 'success') {
                    alert(data['message']);
                    form.reset();
                    remove_selector('.error');
                    remove_selector('.invalid');
                    remove_selector('.valid');
                    remove_selector('.regular');
                }
                if (xhr.status === 200 && data['status'] === 200) {
                    if (data['url']) {
                        window.location.href = '/' + data['url'];
                    } else {
                        alert(data['message']);
                        form.reset();
                    }
                }
                if (data['status'] === 'added') {
                    form.reset();
                    slide_select('form-part', document.getElementById('item-kind'));
                    slide_select('types', document.getElementById('item-cat'));
                    alert(data['message']);
                }
            }
        }
    })

    // функции для обработки элементов
    function split(string, separator) { //разделитель строки
        let strArr = string.split(separator);
        let length = strArr.length;
        return { arr: strArr, count: length };
    }

    function ErrorState(elem) { //Добавление класса ошибочного поля
            document.querySelectorAll(elem).forEach(el => {
            let result = (elem === '.input-wrap') ? el : el.parentNode;
            result.classList.remove('regular');
            result.classList.add('error');
            result.querySelector('label').classList.remove('valid');
            result.querySelector('label').classList.add('invalid');
        });
    }



    function remove_selector(elem){ // удаление инвалид-селектора
        document.querySelectorAll(elem).forEach(el =>{
            el.classList.remove(elem.slice(1));
        });
    }
    function close() {
        document.querySelector('.msg__block').classList.remove('show');
    }
    let close_btn = document.querySelector('.close-btn');
    if(close_btn)
    close_btn.addEventListener("click", close);


    function input_xhr(elem) {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);
                let data = new FormData;
                data.append("name", elem.getAttribute('name'));
                data.append("value", elem.value);

                xhr.onreadystatechange = function () {
                    if(xhr.readyState === 2) {
                        elem.nextElementSibling.style.animation = 'loading 1s 1 linear';
                    }
                }
                xhr.onload = function () {
                    if (xhr.readyState === 4) {
                        let data = JSON.parse(xhr.responseText);
                        let object = document.querySelector('[name = "' +  data['object']+'"]');
                        if (xhr.status === 400 && data['status'] === 'invalid-input') {
                            ErrorState('[name="' + data['object'] + '"]');
                            object.nextElementSibling.textContent = data['message'];
                        }
                        if(data['status'] === 'empty' && xhr.status === 200) {
                            object.nextElementSibling.textContent = data['message'];
                            object.parentElement.classList.remove('error');
                            object.nextElementSibling.classList.remove('invalid');
                            object.parentElement.classList.remove('regular');
                            object.nextElementSibling.classList.remove('valid');
                            close();
                        }
                        if(data['status'] === 'valid') {
                            object.parentElement.classList.remove('error');
                            object.nextElementSibling.classList.remove('invalid');
                            object.parentElement.classList.add('regular');
                            object.nextElementSibling.classList.add('valid');
                            object.nextElementSibling.textContent = data['message'];
                            close();
                        }
                    }
                }
                xhr.send(data);
    }

   let input =  document.querySelectorAll('.support__input input, textarea');
    input.forEach(elem => {
        elem.addEventListener("input", debounce(function () {
            input_xhr(elem);
        },1250  , false), false);
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
})



