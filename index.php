<?php 
    
?><!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js ie6 lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js ie7 lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js ie8 lt-ie9"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="fr_FR"><!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title></title>

    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <meta name="viewport" content="width = device-width, initial-scale = 1.0" />

    <!-- <link rel="icon" href="favicon.ico" />
    <link rel="icon" type="image/png" href="favicon.png" /> -->

    <!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" /> -->
    <link rel="stylesheet" href="styles/styles.css" />
    <!--<link rel="stylesheet/less" type="text/css" href="style.less" />
    <script type="text/javascript" src="js/less.js" ></script>
    <script type="text/javascript">less.watch();</script>-->

    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    
    <script src="http://myconsole.matdev.fr/mylog.dev-6.0.0.js"></script>
    <script type="text/javascript">(function(){var methods=['php','show','hide','info','loop','red','Red','orange','yellow','green','Green','blue','violet','white','grey','black','time','size','key','button','range'];var length=methods.length;var console=(window.log=window.log||{});while(length--){if(!log[methods[length]])log[methods[length]]=function(){};}})();</script>

    <style type="text/css">

    html,body{
        height: 100%;
    }

    b{
        display: block;
    }

    header{
        height: 40px;
        background: #555;
    }

    .content{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding-top: 40px;
    }

    .db{
        position: relative;
        width: 100%;
        float: left;
    }

    .db-left{
        padding-right: 0px;
    }

    .db-right{
        padding-left: 0px;
    }

    .db table{
        position: relative;
        width: 100%;
        height: 100%;
        background: #eee;
        border: solid 1px #666;
        float: left;
        overflow: auto;
        padding: 5px;
    }

    .db_compare{
        
    }

    .db_compare table:nth-child(1){
        /*width: 100%;*/
        float: left;
    }

    .db_compare table:nth-child(2){
        
        /*width: 50%;*/
        float: left;
    }

    table{
        width: 100%;
        text-align: left;
        table-layout:fixed;
        font-size: 13px;
        font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
        /*background: orange; */
    }
    tr{
        /*background: red;*/
        /*border: solid 1px #555;*/
    }
    tr:hover{
        background: rgba(0,0,0,0.1);
    }
    thead tr:nth-child(1) th{
        /*background: #bbb;*/
        background: rgba(0,0,0,0.2);
    }
    thead tr:nth-child(2) th{
        background: rgba(0,0,0,0.1);
        color: rgba(0,0,0,0.5);
        /*color: #666;*/
        /*font-weight: 400;*/
    }
    tbody th{
        font-weight: 300;
    }
    th{
        border: solid 1px rgba(0,0,0,0.2);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        padding: 5px;
        height: 30px;
    }
    .db__structure th:nth-child(7){
        width: 5px;
        background: #999;
    }
    .db__structure thead tr:nth-child(1) th:nth-child(2){
        width: 5px;
        background: #999;
    }

    .block{
        margin-top: 10px;
    }

    .name{
        float: left;
        width: 50%;
        font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;

    }
    .name_right{
        width: 50%;
    }

    .alert{
        background: rgba(0,50,200,0.5) !important;
    }

    table.alert{
        background: rgba(250,0,0,0.5) !important;
    }

    </style>
</head>
<body>

    <header>
	</header>

    <div class="content">


        <pre><?php

        include('DataBase.php');
        include('Compare.php');

        $db_1['host'] = 'localhost';
        $db_1['name'] = 'test-1';
        // $db_1['name'] = 'test-B';
        // $db_1['name'] = 'test-A1';
        $db_1['user'] = 'root';
        $db_1['pass'] = 'root';

        $db_2['host'] = 'localhost';
        $db_2['name'] = 'test-2';
        // $db_2['name'] = 'test-A';
        // $db_2['name'] = 'test-A2';
        $db_2['user'] = 'root';
        $db_2['pass'] = 'root';

        $compare = new Compare($db_1, $db_2);

        $structure = $compare->structure();

        // print_r( $structure );

        ?></pre>

        <?php

        echo $structure;

        ?>

    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.11.1.min.js"><\/script>')</script>
    <!-- <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript">
    $(function(){

        var $table = $('tr');

        for (var i = 0; i < $table.length; i++) {
            var $this = $($table[i]);
            var $th =  $('th', $this);
            var l = $th.length;

            if( $this.parents('.db__structure').hasClass('alert')) continue;

            if(l===3){

                if( $th.eq(0).text() !== $th.eq(2).text() ){
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





