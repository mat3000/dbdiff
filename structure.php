<pre><?php

	include_once('DataBase.php');
	include_once('Compare.php');

	$compare = new Compare($db_1, $db_2);

	$structure = $compare->structure();

?></pre>

<?php

	echo $structure;

?>