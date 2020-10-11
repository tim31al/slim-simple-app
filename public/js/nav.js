'use strict'
let path = window.location.pathname;
let currentLink = Array.from(document.querySelectorAll('a.nav-link'))
    .find(item => {
        if(path.includes('article')) {
            path = '/articles';
        } else if(path.includes('user')) {
            path = '/users';
        }
        return item.getAttribute('href') === path;
    });

if(currentLink) {
    currentLink.parentElement.classList.add('active');
}
