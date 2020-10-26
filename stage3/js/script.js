function addPhone() {
    var inputPhone = document.querySelector('.content__div');

    var divElement = document.createElement('div');
    divElement.setAttribute('class', 'content__tel content__add');

    var inputElement = document.createElement('input');
    var inputButtonElement = document.createElement('input');

    inputButtonElement.setAttribute('type', 'button');
    inputButtonElement.setAttribute('name', 'delete_phone');
    inputButtonElement.setAttribute('value', 'удалить');
    inputButtonElement.setAttribute('class', 'delete_phone');
    inputButtonElement.setAttribute('onclick', 'deletePhone(this)');
    inputElement.setAttribute('type', 'tel');
    inputElement.setAttribute('name', 'phone');
    inputElement.setAttribute('class', 'data-field');

    divElement.append(inputElement);
    divElement.append(inputButtonElement);
    inputPhone.insertAdjacentElement("beforeend", divElement);
}
// var el = document.getElementById("test");
// console.log(el);
function deletePhone(e) {
    e.parentNode.remove();
}

var elem = document.querySelector(".header__burger");

elem.classList.toggle('active');
elem.classList.toggle('active', false);