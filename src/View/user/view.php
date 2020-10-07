<?php
/**
 * @var User $user
 *
 **/

use App\Entity\User;

?>

<h1><?=$user->getFullName() ?></h1>
<p><pre>
<?= print_r($user) ?>
</pre></p>


