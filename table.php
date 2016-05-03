<pre><?php

	include_once('DataBase.php');
	include_once('Compare.php');

	$compare = new Compare($db_1, $db_2);

	// $table = $compare->table('client');
	$table = $compare->table('task');

?></pre>

<?php

	echo $table;

?>