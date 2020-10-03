<?php
/**
 * @var Array $articles
 *
 **/
?>
<ul id="articles">
    <?php foreach ($articles as $article): ?>
		<li style="" data-id="<?=$article['id']?>">
			<a href="/article/<?=$article['id']?>" title="Показать"> <?= $article['title'] ?></a>
		</li>
    <?php endforeach; ?>

</ul>
<!--<div style="margin: 1rem 0;">-->
<!--	<form id="new-art">-->
<!--		<input style="display: block; margin: 0.5rem 0" type="text" name="title" value="">-->
<!--		<textarea style="display: block;" name="content" rows="10"></textarea>-->
<!--		<br>-->
<!--		<input type="submit" value="Save">-->
<!--	</form>-->
<!--</div>-->
