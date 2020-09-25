<?php
/**
 * @var Array $articles
 *
 **/
?>
<ul id="articles">
    <?php foreach ($articles as $article): ?>
		<li style="" data-id="<?=$article['id']?>"><?= $article['title'] ?></li>
    <?php endforeach; ?>

</ul>
