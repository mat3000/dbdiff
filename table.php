<pre><?php

	include_once('DataBase.php');
	include_once('Compare.php');

	$compare = new Compare($db_1, $db_2);

?></pre>

<?php

	// echo $compare->table('client');
	// echo $compare->table('task');
	echo $compare->table('frontpermission');
	echo $compare->table('frontpgroup');
	echo $compare->table('frontpgroup_frontpermission');


?>