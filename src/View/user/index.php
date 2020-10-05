<?php
/**
 * @var <User> $users
 * @var User $user
 *
 **/

use App\Entity\User;

?>
<ul id="articles">
    <?php foreach ($users as $user): ?>
		<li style="" data-id="<?=$user->getId()?>">
			<a href="/user/<?=$user->getId()?>" title="Показать"> <?= $user->getUsername() ?></a>
		</li>
    <?php endforeach; ?>

</ul>

