/* Авторизация */

$('.login-button').click(function(event) {
    event.preventDefault();

    $(`input`).removeClass('error');

    let login = $(`input[name="login"]`).val(),
        password = $(`input[name="password"]`).val();

    $.ajax({
        url: 'src/signin.php',
        type: 'POST',
        dataType: 'json',
        data: {
            login: login,
            password: password
        },
        success(data) {

            if (data.status) {
                if (data.admin_status) {
                    document.location.href = '/profile.php';
                } else {
                    document.location.href = '/user_profile.php'
                }
            } else {
                if (data.type == 1) {
                    data.fields.forEach(function(field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg').removeClass('none').text(data.message);
            }
        }
    });
});

/* Регистрация */

$('.register-button').click(function(event) {

    event.preventDefault();

    $('input').removeClass('error');

    let url = $('input[name="url').val(),
        name = $(`input[name="name"]`).val(),
        surname = $(`input[name="surname"]`).val(),
        birth_date = $(`input[name="birth_date"]`).val(),
        gender = $("input[name='gender']:checked").val(),
        login = $(`input[name="login"]`).val(),
        password = $(`input[name="password"]`).val(),
        password_confirm = $(`input[name="password_confirm"]`).val();

    $.ajax({
        url: '/src/signup.php',
        type: 'POST',
        dataType: 'json',
        data: {
            name: name,
            surname: surname,
            birth_date: birth_date,
            gender: gender,
            login: login,
            password: password,
            password_confirm: password_confirm
        },
        success(data) {
            if (data.status) {
                document.location.href = url;
            } else {
                if (data.type == 1) {
                    data.fields.forEach(function(field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg').removeClass('none').text(data.message);
            }
        }
    })
});

/*Изменение */
$('.change-button').click(function(event) {

    event.preventDefault();

    $('input').removeClass('error');

    let url = $(`input[name="url"]`).val(),
        id = $(`input[name="id"]`).val(),
        name = $(`input[name="name"]`).val(),
        surname = $(`input[name="surname"]`).val(),
        birth_date = $(`input[name="birth_date"]`).val(),
        gender = $("input[name='gender']:checked").val(),
        login = $(`input[name="login"]`).val(),
        password = $(`input[name="password"]`).val(),
        password_confirm = $(`input[name="password_confirm"]`).val();

    $.ajax({
        url: '/src/update.php',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            name: name,
            surname: surname,
            birth_date: birth_date,
            gender: gender,
            login: login,
            password: password,
            password_confirm: password_confirm
        },
        success(data) {
            if (data.status) {
                document.location.href = url;
            } else {
                if (data.type == 1) {
                    data.fields.forEach(function(field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg').removeClass('none').text(data.message);
            }
        }
    })
});

/* сортировка */


$('.sort-button').click(function(event) {

    event.preventDefault();

    $('input').removeClass('error');
    let url = $("input[name='no_sort']").val(),
        sort_type = $("input[name='sort_type']:checked").val(),
        sort_dir = $("input[name='sort_dir']:checked").val();

    $.ajax({
        url: '/src/sort.php',
        type: 'POST',
        dataType: 'json',
        data: {
            sort_type: sort_type,
            sort_dir: sort_dir
        },
        success(data) {
            if (data.status) {
                document.location.href = url + '&sort_type=' + sort_type + '&sort_dir=' + sort_dir;
            } else {
                $('.msg').removeClass('none').text(data.message);
            }
        }
    })
});

/* Установка разбиения на странице */

$('.paginator-button').click(function(event) {

    event.preventDefault();

    $('input').removeClass('error');
    let url = $("input[name='sort']").val(),
        on_page = $("input[name='on_page']").val()

    $.ajax({
        url: '/src/set_paginator.php',
        type: 'POST',
        dataType: 'json',
        data: {
            on_page: on_page,
        },
        success(data) {
            if (data.status) {
                document.location.href = '/profile.php?page=1&on_page=' + on_page + url;
            } else {
                $('.msg2').removeClass('none').text(data.message);
            }
        }
    })
});