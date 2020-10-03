<h1>GLOBAL VARS</h1>
<h2>Server</h2>
<pre>
	<?=print_r($_SERVER)?>
</pre>
<?php if (isset($_SESSION)) : ?>
<h2>Session</h2>
<pre>
	<?=print_r($_SESSION)?>
</pre>
<?php endif; ?>
<h2>Cookies</h2>
<pre>
	<?=print_r($_COOKIE)?>
</pre>