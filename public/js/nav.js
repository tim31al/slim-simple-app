'use strict'
let path = window.location.pathname;
let currentLink = Array.from(document.querySelectorAll('div.nav a'))
    .find(item => {
        if(path.includes('article')) {
            path = '/articles';
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