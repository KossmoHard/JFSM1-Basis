var clicks = 0;
function addInput() {
    clicks += 1;
    var inputPhone = document.querySelector('.add_phone');
    inputPhone.insertAdjacentHTML('beforebegin', '<input type="tel" name="phone['+ clicks +']" class="data-field"><br>');
}

var validator = new FormValidator('login-form', [{
    name: 'fio',
    display: 'ФИО',
    rules: 'required|min_length[9]'
}, {
    name: 'email',
    display: 'Email',
    rules: 'required|valid_email',
}, {
    name: 'phone',
    display: 'Телефон',
    rules: 'required|numeric|exact_length[10]',
}, {
    name: 'age',
    display: 'Возраст',
    rules: 'required|numeric|',
}, {
    name: 'photo',
    display: 'Фото',
    rules: 'required|is_file_type[jpg,png]',
}, {
    name: 'resume',
    display: 'Резюме',
    rules: 'required',
}], function(errors, event) {
    event.preventDefault();

    if (errors.length > 0) {
        var errorString = '';
        console.log(errors);
        //
        let errorMessage = document.createElement('div');
        errorMessage.setAttribute('class', 'error-message');

            for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
                console.log(errors.length, errors[i].element);
                errorMessage.innerHTML = errors[i].message;
                console.log(errors[i]);
                errors[i].element.insertAdjacentElement('afterend', errorMessage);

            }
        //});

        document.querySelectorAll('.data-field').innerHTML = errorString;
    } else {
        var form = document.querySelector("#form");
        var data = '';
        //console.log(form.querySelectorAll('.data-field'));
        // переберём все элементы input, textarea формы  c классом .data-field "
        form.querySelectorAll('.data-field').forEach(function(item) {
            data += '<p>' + item.name + ': ' + item.value + '</p>';
        });
        document.querySelector('.messages').innerHTML = data;
        previewFile();
    }
});

validator.setMessage('required', '\n' + 'Вы должны заполнить поле %s.');
validator.setMessage('min_length', 'Поле %s должно содержать не менее %s символов.');
validator.setMessage('valid_email', 'В поле %s должен быть указан действующий адрес электронной почты.');
validator.setMessage('exact_length', 'Поле %s должно содержать ровно %s символов.');
validator.setMessage('numeric', 'Поле %s должно содержать только цифры.');
validator.setMessage('is_file_type', 'Поле %s должно содержать только файлы %s.');

var el = document.getElementById("submit");
el.addEventListener('click', deleteErrorMessage);

function deleteErrorMessage() {
    let errorMessage = document.querySelector('.error-message');

    if (errorMessage != null) {
        errorMessage.remove();
    }

}

function previewFile() {
    var image = '';
    var file    = document.querySelector('input[type=file]').files[0];
    var reader  = new FileReader();
    reader.readAsDataURL(file);

    reader.onloadend = function () {
        image = '<img src="' + reader.result + '" width="200px">';
        document.querySelector('.messages').insertAdjacentHTML('beforeend', image);
    }
}








