'use strict';

// Содержимое статьи
let div = document.createElement('div');
div.setAttribute('id', 'article');
div.style.cssText = 'margin: 1rem .5rem; padding: .5rem; border: 1px solid #17a2b8; border-radius: 5px;';
let p = document.createElement('p');
div.append(p);
div.onclick = () => div.remove();
//
let articles = getArticles();

// Заголовки статей
let divArticles = document.getElementById('articles');
/**
 * При наведении отобразить
 * @param event
 */
divArticles.onmouseover = function (event) {
    let elem = event.target.closest('a');
    if (!elem) return;

    let id = elem.dataset.id;
    if (!id) return;

    // удалить содержимое, при повторном клике
    let content = elem.querySelector('div.content')
    if (content) {
        content.remove();
        return;
    }

    articles.then(response => {
        let data = response.find(item => item.id == id );
        showArticle(data.content, elem);
    });
}
divArticles.onmouseout = () => {
    div.remove();
}


/**
 *
 * @param content содержимое статьи
 * @param elem элемент к которому привязать содержимое
 */
function showArticle(content, elem) {
    div.innerHTML = content;
    elem.append(div);
}

/**
 * Выборка с базы всех статей
 * @returns {Promise<*>}
 */
async function getArticles() {
    let response = await fetch('/api/articles');
    let json;
    if (response.ok) {
        json = await response.json();
    }
    return json;
}