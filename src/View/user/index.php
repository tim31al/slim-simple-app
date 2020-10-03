<?php
/**
 * @var User $user
 */

use App\Model\User;

?>
<h1>Пользователь <?=$user->getUsername()?></h1>
<div style="margin: 1rem 0;">
	<form name="user">
		<input type="text" name="username" value="">
		<input type="password" name="password" value="">
		<input type="submit" value="Send" id="submit">
	</form>
</div>
