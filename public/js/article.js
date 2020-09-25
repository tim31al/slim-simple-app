'use strict';
let article = document.getElementById('articles');
let divContent = document.createElement('div');
divContent.className = 'content'

divContent.onclick = () => divContent.remove();

article.onclick = function (event) {
    let elem = event.target.closest('li');
    if (!elem) return;

    let id = elem.dataset.id;
    if (!id) return;

    if (elem.querySelector('div.content')) return;

    fetch(`/api/article/${id}`)
        .then(response => response.json())
        .then(data => showArticle(data.content, elem));
}

function showArticle(content, elem) {
    divContent.innerHTML = content;
    elem.append(divContent);
    divContent.prepend(document.createElement('hr'));

}