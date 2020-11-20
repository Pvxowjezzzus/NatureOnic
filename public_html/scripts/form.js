var form = document.forms[0];
var url = form.action;
document.addEventListener("DOMContentLoaded", function(e) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var elm = document.getElementById('item-cat');
        var types = [];
        if(elm) {
            for (var j = 0; j < elm.options.length; j++) {
                if (elm.options[j].selected)
                    types.push(elm.options[j].value);
            }
            formData.append('item-cat', types);
        }
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var data = JSON.parse(xhr.responseText);
            if (xhr.status == 400) {
                alert(data['message']);
            }
            if (xhr.status == 200) {
                if (data['url']) {
                    window.location.href = '/' + data['url'];
                } else {
                    alert(data['message']);
                    form.reset();
                }
            }
            if (data['status'] == 'added') {
                    form.reset();
                    slide_select('form-part', document.getElementById('item-kind'));
                    slide_select('types', document.getElementById('item-cat'));
            }
        }
        xhr.open('POST', url, true);
        xhr.send(formData);


    })
})
