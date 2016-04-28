<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js ie6 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js ie7 lt-ie8"><![endif]-->
<!--[if IE 8]><!--><html class="no-js" lang="fr_FR"><!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>dbdiff</title>

    <meta name="viewport" content="width = device-width, initial-scale = 1.0" />

    <link rel="stylesheet" href="styles/styles.css" />

    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    
    <script src="http://myconsole.matdev.fr/mylog.dev-6.0.0.js"></script>
    <script type="text/javascript">(function(){var methods=['php','show','hide','info','loop','red','Red','orange','yellow','green','Green','blue','violet','white','grey','black','time','size','key','button','range'];var length=methods.length;var console=(window.log=window.log||{});while(length--){if(!log[methods[length]])log[methods[length]]=function(){};}})();</script>

    <style type="text/css">
    </style>

</head>
<body>

    <header>
	</header>

    <div class="content">

        <?php 

        $db_1['host'] = 'localhost';
        $db_1['name'] = 'test-1';
        $db_1['user'] = 'root';
        $db_1['pass'] = 'root';

        $db_2['host'] = 'localhost';
        $db_2['name'] = 'test-2';
        $db_2['user'] = 'root';
        $db_2['pass'] = 'root';

        include('structure.php');

        ?>

    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="js/script.js"></script> -->
    <script type="text/javascript">
    $(function(){

        var $table = $('tr');

        for (var i = 0; i < $table.length; i++) {
            var $this = $($table[i]);
            var $th =  $('th', $this);
            var l = $th.length;

            if( $this.parents('.db__structure').hasClass('alert')) continue;

            if(l===3){

                if( $th.eq(0).text()=='' || $th.eq(2).text()=='' ){
                    if ($th.eq(0).text()=='') {}
                    if ($th.eq(2).text()=='') {}
                    $this.parents('.db__structure').addClass('alert');
                }

            }

            if(l===13){

                if( $th.eq(0).text() !== $th.eq(7).text() ){
                    $th.eq(0).addClass('alert');
                    $th.eq(7).addClass('alert');
                    $this.addClass('alert');
                }

                if( $th.eq(1).text() !== $th.eq(8).text() ){
                    $th.eq(1).addClass('alert');
                    $th.eq(8).addClass('alert');
                    $this.addClass('alert');
                }

                if( $th.eq(2).text() !== $th.eq(9).text() ){
                    $th.eq(2).addClass('alert');
                    $th.eq(9).addClass('alert');
                    $this.addClass('alert');
                }

                if( $th.eq(3).text() !== $th.eq(10).text() ){
                    $th.eq(3).addClass('alert');
                    $th.eq(10).addClass('alert');
                    $this.addClass('alert');
                }

                if( $th.eq(4).text() !== $th.eq(11).text() ){
                    $th.eq(4).addClass('alert');
                    $th.eq(11).addClass('alert');
                    $this.addClass('alert');
                }

                if( $th.eq(5).text() !== $th.eq(12).text() ){
                    $th.eq(5).addClass('alert');
                    $th.eq(12).addClass('alert');
                    $this.addClass('alert');
                }

            }
        }

    });
    </script>
</body>
</html>





