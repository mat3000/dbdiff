<pre><?php

	include('DataBase.php');
	include('Compare.php');

	$compare = new Compare($db_1, $db_2);

	$structure = $compare->structure();

?></pre>

<?php

	echo $structure;

?>