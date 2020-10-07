<?php
/**
 * @var array $products
 * @var \App\Entity\Product $product
 *
 **/
?>
<ul id="articles">
    <?php foreach ($products as $product): ?>
		<li style="" data-id="<?=$product->getId()?>">
			<a href="/product/<?=$product->getId()?>" title="Показать"> <?= $product->getName() ?></a>
		</li>
    <?php endforeach; ?>

</ul>

