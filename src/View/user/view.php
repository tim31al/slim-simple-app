<?php
/**
 * @var User $user
 *
 **/

use App\Entity\User;

?>

<h1><?=$user->getFullname() ?></h1>
<p><pre>
<?= print_r($user) ?>
</pre></p>


