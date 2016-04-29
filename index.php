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

        <p><input type="checkbox" name="hide" id="hide"/><label for="hide" > hide</label></p>

	</header>

    <div class="content">

        <?php 

        $db_1['host'] = 'localhost';
        // $db_1['name'] = 'test-1';
        $db_1['name'] = 'total-refontedam-1';
        $db_1['user'] = 'root';
        $db_1['pass'] = 'root';

        $db_2['host'] = 'localhost';
        // $db_2['name'] = 'test-2';
        $db_2['name'] = 'total-refontedam-2';
        $db_2['user'] = 'root';
        $db_2['pass'] = 'root';

        include('structure.php');

        ?>

    </div>



    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="js/script.js"></script> -->
    <script type="text/javascript">
    $(function(){

        $('#hide').click(function(){

            if($(this).prop('checked')){

                $('.no-diff').hide();

            }else{  


                $('.no-diff').show();

            }
        });

        /*$(document).on('mouseenter', '.db__structure tbody tr', function(){

            var $this = $(this);
            var $block = $(this).parents('.block');

            $('tr').removeClass('hover');
            $('.db-left tbody tr:eq('+$this.index()+'), .db-right tbody tr:eq('+$this.index()+')', $block).addClass('hover');

        });

        $(document).on('mouseleave', '.db__structure tbody tr', function(){

            $('.db-left tbody tr').removeClass('hover');

        });*/


        var $block = $('.block');

        // block
        loop1 : for (var i = 0; i < $block.length; i++) {

            var $this_block = $($block[i]);
            var $tr_left = $('.db-left tbody tr', $this_block);
            var $tr_right = $('.db-right tbody tr', $this_block);

            var diff = 0;


            if( $('.db-left .db__table-name', $this_block).text()==='' ){

                $('.db-left .db__table-name', $this_block).addClass('diff-red');
                $('.db-left .db__structure', $this_block).addClass('diff-red');
                diff++;

            }else if( $('.db-right .db__table-name', $this_block).text()==='' ){

                $('.db-right .db__table-name', $this_block).addClass('diff-red');
                $('.db-right .db__structure', $this_block).addClass('diff-red');
                diff++;

            }else{

                // line
                loop2 : for (var ii = 0; ii < $tr_left.length; ii++) {

                    var $this_tr_left = $($tr_left[ii]);
                    var $this_tr_right = $($tr_right[ii]);

                    var $th_left = $('th', $this_tr_left);
                    var $th_right = $('th', $this_tr_right);

                    // colonne
                    loop3 : for (var iii = 0; iii < $th_left.length; iii++) {

                        var $this_th_left = $($th_left[iii]);
                        var $this_th_right = $($th_right[iii]);


                        if( iii===0 && $this_th_left.text()=='' ){

                            $this_tr_left.addClass('diff-red');
                            diff++;
                            break loop3;

                        }else if( iii===0 && $this_th_right.text()=='' ){

                            $this_tr_right.addClass('diff-red');
                            diff++;
                            break loop3;

                        }else if($this_th_left.text() !== $this_th_right.text()){

                            $this_tr_left.addClass('diff-blue');
                            $this_tr_right.addClass('diff-blue');
                            $this_th_left.addClass('diff-blue');
                            $this_th_right.addClass('diff-blue');
                            diff++;

                        }

                    }

                }

            }

            if(!diff){
                $this_block.addClass('no-diff');
            }

            log.green(diff, $('.db__table-name', $this_block).text() )

        }

    });
    </script>
</body>
</html>





