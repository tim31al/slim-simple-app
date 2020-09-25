<?php
/**
 * @var String $title
 * @var String $content
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<style>
        .wrapper {
            padding: 1rem 2rem;
        }

        #articles {
            display: inline-block !important;
            min-width: 20%;
        }

        #articles li {
            cursor: pointer;
            padding: .5rem 1rem;
            border: 1px solid lightskyblue;
            list-style-type: none;
        }

        .content {
            padding: 2rem 0;
            font-style: italic;
            cursor: pointer;
        }

        .nav {
            margin: 0;
            padding: .5rem 2rem;
        }

        .nav li {
            display: inline-block;
            text-decoration: none;
            padding: 3px 8px;
            margin: 5px 0 5px 10px;
            border: 2px solid dimgrey;
            box-shadow: gray;
            border-radius: 4px;
	        color: dimgrey;
        }

        .nav li:hover {
            cursor: pointer;
	        background-color: dimgrey;
        }
        .nav li:hover a {
	        color: white;
        }

        .nav li a {
            text-decoration: none;
            color: dimgrey;
        }


	</style>
</head>
<body>
<div class="nav">
	<ul>
		<li><a href="/" title="Главная">Main</a></li>
		<li><a href="/server" title="Сервер">Server</a></li>
<!--		<li><a href="/hello" title="Hello">Hello</a></li>-->
		<li><a href="/user" title="User">User</a> </li>
		<li><a href="/articles" title="Статьи">Articles</a></li>
		<li><a href="/api/articles" title="Api">Api</a> </li>
	</ul>
</div>
<div class="wrapper">
    <?= $content ?>
	<div class="tester"
	     style="border: 1px solid deepskyblue; border-radius: 4px; margin: 1rem; padding: 1rem; width: 50%">
		<button id="test">Test</button>
	</div>

</div>

<!--promise tests-->
<script>
    if (window.location.pathname === '/')
        getTest();
    else
        document.querySelector('div.tester').remove();

    function getTest() {
        let btn = document.getElementById('test');

        btn.addEventListener('click', showApi);

        function showApi() {
            let counter = 0;
            let ids = [2, 19, 20];
            let url = '/api/article/';

            Promise.all(ids.map(id => fetch(`${url}${id}`)))
                .then(responses => Promise.all(responses.map(r => r.json())))
                .then(results => results.forEach(r => console.log(r)))
                .catch(er => console.log(er));
        }
    }
</script>

<script>
    'use strict';
    let article = document.getElementById('articles');
    let divContent = document.createElement('div');
    divContent.className = 'content'

    divContent.onclick = () => divContent.remove();

    if(article) {
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
    }

    function showArticle(content, elem) {
        divContent.innerHTML = content;
        elem.append(divContent);
        divContent.prepend(document.createElement('hr'));

    }
</script>
</body>
</html>