<?php
/**
 * @var String $title
 * @var String $content
 * @var array $scripts
 * @var AuthenticationService $auth
 */

use App\Service\AuthenticationService;

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

        .active {
            color: white;
            background-color: dimgrey;
        }


	</style>
</head>
<body>
<div class="nav">
	<ul>
		<li><a href="/" title="Главная">Main</a></li>
		<li><a href="/server" title="Сервер">Server</a></li>
		<li><a href="/users" title="User">Users</a></li>
		<li><a href="/articles" title="Статьи">Articles</a></li>
		<li><a href="/api/articles" title="Api">Api</a></li>
		<li><a href="<?= $auth->hasIdentity() ? '/logout' : '/login'?>"><?= $auth->hasIdentity() ? 'Logout' : 'Login' ?></a></li>
	</ul>
</div>
<div class="wrapper">
    <?= $content ?>
</div>

<?php if (isset($scripts)) : ?>
    <?php foreach ($scripts as $script) : ?>
		<script src="js/<?= $script ?>.js"></script>
    <?php endforeach; ?>
<?php endif; ?>

<script src="/js/nav.js"></script>
</body>
</html>