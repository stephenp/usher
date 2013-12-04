<?php
	session_start();

	$_SESSION['url'] = $_SERVER['REQUEST_URI'];

function human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }


	if ($_SESSION['authenticated'] != true) {
       header('Location: login.php');
       return;
   } else {
?>


<html>
        <head>
                <title>Media Server</title>
                <?php include_once('./rsrc/inc/includes.php'); ?>  

        </head>

        <body>

            <?php 
            	$activeNav = "dashboard";
            	include_once('./rsrc/inc/nav.php'); 
            ?>  

	        <ul id="serviceSwitcher" class="modal transparent clearfix">
	        	<li><a href="http://81delmar.dlinkddns.com:32400/web"><img src="rsrc/img/plex.png"></a></li>
	        	<li><a href="http://81delmar.dlinkddns.com:9091"><img src="rsrc/img/transmission.png"></a></li>
	        	<li class="last"><a href="http://81delmar.dlinkddns.com:8081"><img src="rsrc/img/sickbeard.png"></a></li>
	        </ul>
	        
	        <?php include_once('./rsrc/inc/widgets.php'); ?>  

        </body>
</html>

<?php
}
?>