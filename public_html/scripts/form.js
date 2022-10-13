let form = document.forms[0];

var input = document.getElementsByTagName('input');
var alert_block = document.getElementById('alert-block');
let alert_email = document.querySelector('.alert-block_email');
let alert_password = document.querySelector('.alert-block_password');

function show_alert(data) {

    alert_block.classList.add('show');
    alert_block.querySelector('span').innerHTML = data['message'];


    if (data['status'] == 400)
        alert_block.classList.add('alert-danger');


    if (data['status'] == 200)
        alert_block.classList.add('alert-success');

}

if (document.getElementById('close-btn')) {
    document.getElementById('close-btn').addEventListener('click', function() {
        alert_block.classList.remove('show');
    })
}


document.addEventListener("DOMContentLoaded", function() {
    if (document.forms[0]) {

        let url = form.action;
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
            let url = form.action;
            xhr.open('POST', url, true);
            xhr.send(formData);
            xhr.onload = function() {
                let data = JSON.parse(xhr.responseText);
                if (xhr.readyState === 4) {
                    if (xhr.status === 400) {
                        if (data['object'] == 'form') {
                            show_alert(data);
                        } else {
                            show_alert(data);
                        }
                    }
                    if (data['url'] == 'admin') {
                        window.location = '/admin';
                    }
                    if (xhr.status === 200 && data['status'] === 'success') {
                        alert(data['message']);
                        alert_block.querySelector('span').innerHTML = '';
                        alert_block.classList.remove('show');
                        form.reset();

                    }
                    if (xhr.status === 200 && data['status'] === 200) {
                        if (data['url']) {
                            window.location.href = '/' + data['url'];
                        } else {
                            alert(data['message']);
                            location.reload();
                            form.reset();
                        }
                    }
                    if (data['status'] === 'added') {
                        let file_label = document.querySelector('.custom-file-label');
                        alert(data['message']);
                        form.reset();
                        alert_block.querySelector('span').innerHTML = '';
                        alert_block.classList.remove('show');
                        file_label.classList.remove('selected');
                        file_label.innerHTML = 'Выберите изображение';
                        slide_select('types', document.getElementById('item-cat'));

                    }
                }

            }
        });
    }
});


function changeData(input) {
    let url;
    let formData = new FormData();
    if (input === 'email') {
        formData.append('new_email', document.getElementById('new_email').value);
        formData.append('password', document.getElementById('password').value);
        url = '/admin/change/email';
    }
    if (input === 'password') {
        formData.append('password', document.getElementById('old_password').value);
        formData.append('new_password', document.getElementById('new_password').value);
        formData.append('verify_password', document.getElementById('verify_password').value);
        url = '/admin/change/password';
    }
    let xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.send(formData);
    xhr.onload = function() {
        let data = JSON.parse(xhr.responseText);
        if (xhr.readyState === 4) {
            if (xhr.status === 400 && input === 'email') {
                alert_email.classList.add('show');
                alert_email.classList.add('alert-danger');
                alert_email.querySelector('span').innerHTML = data['message'];
            }
            if (xhr.status === 400 && input === 'password') {
                alert_password.classList.add('show');
                alert_password.classList.add('alert-danger');
                alert_password.querySelector('span').innerHTML = data['message'];
            }
            if (xhr.status === 200) {
                alert(data['message']);
                location.reload();
            }
        };
    }
}
if (document.getElementById('changeEmailBtn')) {
    document.getElementById('changeEmailBtn').onclick = function() {
        changeData('email');
    }
}
if (document.getElementById('changePasswordBtn')) {
    document.getElementById('changePasswordBtn').onclick = function() {
        changeData('password');
    }
}

function split(string, separator) { //разделитель строки
    let strArr = string.split(separator);
    let length = strArr.length;
    return { arr: strArr, count: length };
}



$('#auth_form').validate({
    rules: {
        email: {
            required: true,
            email: true,
        },
        username: {
            minlength: 5,
            maxlength: 25,
            required: true,
        },
        password: {
            required: true,
            minlength: 8,
            maxlength: 50,
        },
        password_verify: {
            required: true,
            maxlength: 50,
            equalTo: "#password"
        }
    },
    errorElement: "p",
    messages: {
        username: {
            required: 'Заполните это поле',
            minlength: "Имя должно быть от 5 до 25 символов"
        },
        email: {
            required: 'Заполните это поле',
            email: 'Неверный формат почты'
        },
        password: {
            required: "Заполните это поле",
            minlength: "Пароль должен состоять минимум из 8 символов",
            maxlength: "Пароль должен состоять максимум из 50 символов"
        },
        password_verify: {
            required: "Заполните это поле",
            minlength: "Пароль должен состоять из 8 символов",
            maxlength: "Пароль должен состоять максимум из 50 символов",
            equalTo: "Введите такой же пароль как и выше"
        },
    },
    highlight: function(element, errorClass, validClass) {
        $(element).children('.input-wrap input').addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).children('.form-control').addClass("is-valid").removeClass("is-invalid");
    }
})
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
$("#EmailModal").on('hidden.bs.modal', function() {
    $(this).find("input").val('').end();
    $('.alert-block_email span').text('');
    $('.alert-block_email').removeClass('show');
});
$("#PasswordModal").on('hidden.bs.modal', function() {
    $(this).find("input").val('').end();
    $('.alert-block_password span').text('');
    $('.alert-block_password').removeClass('show');
});

$(".profile-nav a").click(function(e) {
    e.preventDefault();
    $(".profile-nav a").removeClass('active-prof');
    $(this).addClass('active-prof');

    if (this.id === 'users') {
        $('.users').removeClass('noshow');
        $('.rightbox').children().not('.users').addClass('noshow');
    } else if (this.id === 'profile') {
        $('.profile').removeClass('noshow');
        $('.rightbox').children().not('.profile').addClass('noshow');
    } else if (this.id === 'settings') {
        $('.settings').removeClass('noshow');
        $('.rightbox').children().not('.settings').addClass('noshow');
    }
})