<pre><?php

	include('DataBase.php');
	include('Compare.php');

	$compare = new Compare($db_1, $db_2);

	$table = $compare->table('client');

?></pre>

<?php

	echo $table;

?>