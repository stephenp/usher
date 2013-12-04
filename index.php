<?php
	session_start();

	$_SESSION['url'] = $_SERVER['REQUEST_URI'];

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
            	$activeNav = "home";
            	include_once('./rsrc/inc/nav.php'); 
            ?>  

	        
	        <?php include_once('./rsrc/inc/widgets.php'); ?>
	        
	

        </body>
</html>

<?php
}
?>
