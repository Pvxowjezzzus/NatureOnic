let btn = document.querySelector('.drop-btn');
let drop = document.querySelector('.drop-menu');
var types = document.querySelector('#item-kind');
btn.addEventListener("click", function(){
    drop.classList.toggle("active");
}, false);

function slide(name) {
    var obj = document.getElementById(name);
    obj.classList.toggle('fadeInDown');
    obj.toggleAttribute('hidden');
}

function slide_select(name, e) {
    var obj = document.getElementById(name);
    if(e.value !== '') {
        obj.classList.add('fadeInDown');
        obj.removeAttribute('hidden');
        obj.style.display = 'flex';
    }
    else {
        obj.classList.remove('fadeInDown');
        obj.setAttribute('hidden', true);
        obj.style.display = 'none';
    }
}
    function get_values(e, callback, param) {
    var data = e.value || e;
    var xhr = new XMLHttpRequest();
    xhr.onloadstart = function() {
        types.setAttribute('hidden', true);
    }

    xhr.onload = function() {
        types.removeAttribute("hidden");

        var data = xhr.responseText;
        types.innerHTML = '<option value="">-</option>';
        types.insertAdjacentHTML("BeforeEnd", '<option value="null" id="null">Без разновидностей</option>');

        if (data == "") {

        }
            else {
                types.insertAdjacentHTML("BeforeEnd", data);
            }
        if(param !== null)
            callback(param);
        }

    xhr.open('GET', '/admin/items/add?cat=' + data, true);
    xhr.send();
}

function select_type(type) {
        var x = document.getElementById("item-kind").options.namedItem(type);
        x.setAttribute('selected', true);
   }


