<?php
/**
 * @var Article$article
 *
 **/

use App\Entity\Article;

?>
<h1><?= $article->getTitle() ?></h1>
<p><?= $article->getContent() ?></p>
<p><?= $article->getDate()->format('d.m.Y H:s') ?></p>

