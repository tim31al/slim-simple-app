'use strict'

let form = document.forms[0];

form.onsubmit = async function (event) {
    event.preventDefault();

    let data = {'title': this.elements.title.value, 'content': this.elements.content.value };

    let response = await fetch('/api/article', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data),
    });

    let result = await response.json();

    console.log(`last insert id: ${result.id}`);

    let li = document.createElement('li');
    li.setAttribute('data-id', result.id);
    li.textContent = data.title;
    document.getElementById('articles').append(li);
}
