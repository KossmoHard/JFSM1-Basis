var clicks = 0;
function addPhone() {
    clicks += 1;
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
    inputElement.setAttribute('name', 'phone['+ clicks +']');
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


let isMobile = {
    Android: function() {return navigator.userAgent.match(/Android/i);},
    BlackBerry: function() {return navigator.userAgent.match(/BlackBerry/i);},
    iOS: function() {return navigator.userAgent.match(/iPhone|iPad|iPod/i);},
    Opera: function() {return navigator.userAgent.match(/Opera Mini/i);},
    Windows: function() {return navigator.userAgent.match(/IEMobile/i);},
    any: function() {return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());}
};

var body = document.querySelector('body');

if(isMobile.any()) {
    var navTrigger = document.getElementsByClassName('nav-trigger')[0];

    navTrigger.addEventListener('click', toggleNavigation);

    function toggleNavigation(event) {
        event.preventDefault();
        body.classList.toggle('nav-open');
    }

    body.classList.add('touch');
    let arrow = document.querySelectorAll('.arrow-menu');
    for(i = 0; i < arrow.length; i++) {
        let thisLink = arrow[i].previousElementSibling;
        let subMenu = arrow[i].nextElementSibling;
        let thisArrow = arrow[i];

        thisLink.classList.add('parent');
        arrow[i].addEventListener('click', function(){
            subMenu.classList.toggle('open');
            thisArrow.classList.toggle('active');
        });
    }

} else {
    body.classList.add('mouse');
}
