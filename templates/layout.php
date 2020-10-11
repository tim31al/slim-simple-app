<?php
/**
 * @var string $title
 * @var string $content
 * @var array $scripts
 * @var AuthenticationService $auth
 * @var string $style
 */

use App\Service\AuthenticationService;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<link type="text/css" href="<?= $style ?>" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="/">MyApp</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
	        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/server">Server</a>
			</li>
            <?php if ($auth->isAdmin()): ?>
				<li class="nav-item">
					<a class="nav-link" href="/users">Users</a>
				</li>
            <?php endif; ?>
			<li class="nav-item">
				<a class="nav-link" href="/articles">Articles</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href=""></a>
			</li>
		</ul>
		<ul class="nav navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="<?= $auth->hasIdentity() ? '/logout' : '/login' ?>">
					<span class="fas fa-sign-in-alt"></span>
                    <?= $auth->hasIdentity() ? 'Logout' : 'Login' ?>
				</a>
			</li>
		</ul>
	</div>
</nav>
<div class="container my-4">
    <?= $content ?>
</div>
<script src="/js/nav.js"></script>
<?php if (isset($scripts)) : ?>
    <?php foreach ($scripts as $script) : ?>
		<script src="js/<?= $script ?>.js"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>