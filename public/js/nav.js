'use strict'
let path = window.location.pathname;
let currentLink = Array.from(document.querySelectorAll('div.nav a'))
    .find(item => {
        console.log(path);
        if(path.includes('article')) {
            path = '/articles';
        } else if(path.includes('product')) {
            path = '/products';
        } else if(path.includes('user')) {
            path = '/users';
        }
        return item.getAttribute('href') === path;
    });

if(currentLink) {
    setActive(currentLink);
}

function setActive(elem) {
    elem.style.color = 'white';
    elem.parentElement.style.backgroundColor = 'dimgrey';
}