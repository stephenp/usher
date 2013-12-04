<?php
	session_start();

	if(isset($_SESSION['url'])) { 
	   $url = $_SESSION['url']; // holds url for last page visited.
	   } else {
		   $url = "/index.php"; // default page fo
		   }

	if ($_SESSION['authenticated'] == true) {
	   // Go somewhere secure
	   header("Location: http://".$_SERVER['HTTP_HOST'].$url);
	} else {

	   $error = null;
	   if (!empty($_POST)) {
	       $password = empty($_POST['password']) ? null : $_POST['password'];
	
	       if ($password == $secretpassword) {
	           $_SESSION['authenticated'] = true;
	           // Redirect to your secure location
	           header("Location: http://".$_SERVER['HTTP_HOST'].$url);

	           return;
	       } else {
	           $error = 'Shake it like a salt shaker';
	       }
	   } else {

		// Remove the background session file on each reload.
		unset($_SESSION['sessionBackground']);
		}
?>


<html>
        <head>
                <title>Media Server</title>
                <?php include_once('./rsrc/inc/includes.php'); ?>  
        </head>

        <body>
        	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="login" class="modal transparent<?php if (isset($error)) {echo ' error';}?>" method="post">
        		<input type="password" name="password" id="password" class="text">
        	</form>
        	<div class="result"></div>
        </body>
</html>

<?php
}
?>
