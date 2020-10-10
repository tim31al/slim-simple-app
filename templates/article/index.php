<?php
/**
 * @var array $articles
 * @var Article $article
 *
 **/

use App\Entity\Article;
?>
<h1 class="h2">Sample articles</h1>
<div class="list-group list-group-flush">
	<?php foreach ($articles as $article): ?>
	<a href="/article/<?= $article->getId() ?>" class="list-group-item list-group-item-action">
		<?= $article->getTitle() ?>
	</a>
	<?php endforeach; ?>
</div>