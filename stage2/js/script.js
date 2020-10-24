// function clickButton(){
//
//     let data = {}
//     let form = document.querySelector("#form");
//     console.log(form);
//
//     // переберём все элементы input, textarea и select формы с id="myForm "
//     form.querySelectorAll('input, textearea, select').forEach(function(item) {
//         data[item.name] = item.value;
//     });
//     console.log(data);
// }
//
// function addInput() {
//     let inputPhone = document.querySelector('.phone');
//     inputPhone.insertAdjacentHTML('beforeend', '<input type="tel" name="phone[]" class="phone"><br>');
// }

var validator = new FormValidator('login-form', [{
    name: 'fio',
    display: 'ФИО',
    rules: 'required|min_length[9]'
}, {
    name: 'email',
    display: 'Email',
    rules: 'valid_email',
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
        let errorString = '';

        for (let i = 0, errorLength = errors.length; i < errorLength; i++) {
            errorString += errors[i].message + '<br />';
        }
        document.querySelector('.errors-massages').innerHTML = errorString;
    }
});

validator.setMessage('required', '\n' + 'Вы должны заполнить поле %s.');
validator.setMessage('min_length', 'Поле %s должно содержать не менее %s символов.');
validator.setMessage('email', 'В поле %s должен быть указан действующий адрес электронной почты.');
validator.setMessage('exact_length', 'Поле %s должно содержать ровно %s символов.');
validator.setMessage('numeric', 'Поле %s должно содержать только цифры.');
validator.setMessage('is_file_type', 'Поле %s должно содержать только файлы %s.');









