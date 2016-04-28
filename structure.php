<pre><?php

	include('DataBase.php');
	include('Compare.php');

	$compare = new Compare($db_1, $db_2);

	$structure = $compare->structure();

	// $table = $compare->table('client');

?></pre>

<?php

	echo $structure;
	// echo $table;

?>