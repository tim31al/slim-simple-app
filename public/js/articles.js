'use strict';

// Содержимое статьи
let divContent = document.createElement('div');
divContent.className = 'content'
divContent.onclick = () => divContent.remove();

// Все статьи
let articles = getArticles();

// Заголовки статей
let divArticles = document.getElementById('articles');
/**
 * При клике на заголовке, отобразить содежимое
 * @param event
 */
divArticles.onclick = function (event) {
    let elem = event.target.closest('li');
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

/**
 *
 * @param content содержимое статьи
 * @param elem элемент к которому привязать содержимое
 */
function showArticle(content, elem) {
    divContent.innerHTML = content;
    elem.append(divContent);
    divContent.prepend(document.createElement('hr'));

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