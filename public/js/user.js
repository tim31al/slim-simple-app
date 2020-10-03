'use strict'

let form = document.forms[0];

form.onsubmit = function (event) {
    event.preventDefault();
    console.log(event);

    let data = { 'username': form.elements.username.value, 'password': form.elements.password.value };
    //
    console.log(data);
}