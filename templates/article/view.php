<?php
/**
 * @var Article $article
 *
 **/

use App\Entity\Article;

?>
<h1 class="h2"><?= $article->getTitle() ?></h1>
<p>
	<?= $article->getContent() ?>
	<span class="d-block border-left small p-2"><?= $article->getDate()->format('d.m.Y H:s') ?></span>
</p>

