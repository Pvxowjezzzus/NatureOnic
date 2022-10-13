let form = $('form');
$(window).on("scroll", function() {
    if ($(document).scrollTop() > 200) {
        $('.navbar').removeClass('py-3')
        $('.top-header').hide()
        $('.navbar').addClass('affix')
        $('.navbar').addClass('fixed-top')
    } else {
        $('.navbar').removeClass('affix')
        $('.navbar').removeClass('fixed-top')
        $('.navbar').addClass('py-3')
        $('.top-header').show()
    }
});
$('.search-bar input').keyup(function() {
    let query = $(this).val();
    $.ajax({
        url: '/form/handler.php',
        type: 'POST',
        cache: false,
        dataType: 'html',
        data: { query: query },
        success: function(data) {
            $('#search-res').html(data);
        }
    })
})

function getQueryVar(variable) {

    const item = decodeURIComponent(window.location.search.substring(1));
    const vars = item.split('&');

    for (i = 0; i < vars.length; i++) {
        let pair = vars[i].split('=');
        if (pair[0] === variable)
            return pair[1];
    }
    return (false);
}
$(document).ready(function() {
    let param = getQueryVar('item');
    $('.product-select option[value="' + param + '"]').attr('selected', 'selected');
    if (param !== false)
        $('.product-select').parent().addClass('regular');
})

$('#request-form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '/request/send',
        method: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(data) {
            alert(data.message);
            $('#request-form')[0].reset();
            remove_selector('.error');
            remove_selector('.invalid');
            remove_selector('.valid');
            remove_selector('.regular');
        },
        error: function(data) {
            const ajaxData = JSON.parse(data.responseText);
            let error_block = $('.msg__block');
            $('.msg__block').children('span:eq(0)').text(ajaxData.message);
            $('.msg__block').addClass('alert-danger');
            error_block.fadeIn('slow');
        }

    });
})

function close() {
    $('.msg__block').fadeOut('fast');
}
let close_btn = $('.close-btn');
if (close_btn)
    close_btn.on("click", close);

let field = new Array("username", "email", "message", "product");

$("form").on("submit", function(e) {
    e.preventDefault();
    var error = 0; // индекс ошибки
    $(".input-select select,.input-wrap input,textarea").each(function() {
        for (var i = 0; i < field.length; i++) {
            if ($(this).attr("name") == field[i]) {

                if (!$(this).val()) {
                    $(this).parent().addClass('error');
                    $(this).next().addClass('invalid');
                    error = 1;
                }
            }
        }
    });
});


function ErrorState(elem) { //Добавление класса ошибочного поля
    document.querySelectorAll(elem).forEach(el => {
        let result = (elem === '.input-wrap') ? el : el.parentNode;
        result.classList.remove('regular');
        result.classList.add('error');
        result.querySelector('label').classList.remove('valid');
        result.querySelector('label').classList.add('invalid');
    });
}

function remove_selector(elem) { // удаление инвалид-селектора
    document.querySelectorAll(elem).forEach(el => {
        el.classList.remove(elem.slice(1));
    });
}