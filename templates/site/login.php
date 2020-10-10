<?php
/* @var Result|string $result  */
/* @var array $data */

use App\Service\Result;

?>
<div class="col-md-6 mx-auto">
	<form method="post">
		<div class="form-group" id="login">
			<label for="username">Username</label>
			<input type="text" class="form-control" name="username" value="<?=$data['username']?>">
			<small id="usernameHelp" class="form-text  text-danger">
                <?php if ($result instanceof \App\Service\Result &&
                    ($result->getCode() === -1 || $result->getCode() === -2)) {
                   echo implode(' ', $result->getMessages());
                }
                ?>
			</small>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" name="password" value>
			<small id="passwordHelp" class="form-text text-danger">
                <?php if ($result instanceof \App\Service\Result &&
                    ($result->getCode() === -3)) {
                    echo implode(' ', $result->getMessages());
                }
                ?>
			</small>
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>

</div>
