<?php
/**
 * @var Product $product
 *
 **/

use App\Entity\Product;

?>

<h1><?=$product->getName() ?></h1>
<p><?=$product->getDescription() ?></p>
<p><?=$product->getCreatedAt() ?></p>

