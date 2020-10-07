<?php
/**
 * @var <Article> $articles
 *
 **/

use App\Entity\Article;
?>
<ul id="articles">
    <?php foreach ($articles as $article): ?>
		<li style="" data-id="<?=$article->getId()?>">
			<a href="/article/<?=$article->getId()?>" title="Показать"> <?= $article->getTitle() ?></a>
		</li>
    <?php endforeach; ?>

</ul>

