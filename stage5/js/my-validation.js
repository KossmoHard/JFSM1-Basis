var validator = new FormValidator('login-form', [{
    name: 'fio',
    display: 'ФИО',
    rules: 'required|min_length[9]'
}, {
    name: 'email',
    display: 'Email',
    rules: 'required|valid_email',
}, {
    name: 'phone[0]',
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
        console.log(errors);

            for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
                let errorMessage = document.createElement('div');
                let elementId = errors[i].element.id;
                errorMessage.setAttribute('class', 'error-message');
                console.log(i, errors[i].element, errors[i].message);
                errorMessage.innerHTML = errors[i].message;

                if (elementId === 'tel') {
                    errors[i].element.parentElement.insertAdjacentElement('afterend', errorMessage);
                } else if ( errors[i].element instanceof NodeList ) {
                    console.log('errors[i].element');
                    errors[i].element.forEach( function (item) {
                        item.parentElement.insertAdjacentElement('afterend', errorMessage);
                    });
                } else {
                    console.log(errors[i].element instanceof NodeList);
                    console.log('Aaaaaaaa', errors[i].element);
                    errors[i].element.insertAdjacentElement('afterend', errorMessage);
                }

            }

        handleButtonClick();

    } else {
        sendForm();
    }
});

validator.setMessage('required', '\n' + 'Вы должны заполнить поле %s.');
validator.setMessage('min_length', 'Поле %s должно содержать не менее %s символов.');
validator.setMessage('valid_email', 'В поле %s должен быть указан действующий адрес электронной почты.');
validator.setMessage('exact_length', 'Поле %s должно содержать ровно %s символов.');
validator.setMessage('numeric', 'Поле %s должно содержать только цифры.');
validator.setMessage('is_file_type', 'Поле %s должно содержать только файлы %s.');


async function sendForm() {
    var formElem = document.querySelector('#form');
    let response = await fetch('update_data.php', {
        method: 'POST',
        body: new FormData(formElem)
    });

    let result = await response.json();
    console.log(response);
    if (result.ok) {
        document.getElementById('success-message').innerHTML = result.ok;
        document.getElementById('success-message').setAttribute('class', 'show');

    } else {
        console.log(Object.keys(result).length);
        getValidate(result);
    }
}

var el = document.getElementById("submit");
el.addEventListener('click', deleteErrorMessage);

function deleteErrorMessage() {
    let errorMessage = document.querySelectorAll('.error-message');

    if (errorMessage != null) {
        errorMessage.forEach(function(item) {
            item.remove();
        });
    }

}

function handleButtonClick() {
    var hiddenElement = document.querySelectorAll('.error-message');
    hiddenElement[0].scrollIntoView({block: "center", behavior: "smooth"});
}

var uploadFile = document.getElementById('upload-file');
uploadFile.addEventListener('change', previewFile);
function previewFile(event) {
    console.log(event);
    let imageUpload = document.getElementById('image-upload');
    let file = event.target.files[0];

    if ( file ) {
        var reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onloadend = function () {
            imageUpload.src = reader.result;
        }

    } else {
        imageUpload.src = 'img/imageupload.png';
    }

}

function getValidate(data) {

    for (let item in data) {
        var errorMessage = document.createElement('div');
        errorMessage.setAttribute('class', 'error-message');
        errorMessage.innerHTML = data[item];
        if (item !== 'phone') {
            console.log(item, document.getElementById(item))
            document.getElementById(item).insertAdjacentElement("afterend", errorMessage);
        } else {
            document.getElementById('test').insertAdjacentElement("afterend", errorMessage);
        }
    }

    handleButtonClick();
}






