<?php
	session_start();
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];

	if ($_SESSION['authenticated'] != true) {
       header('Location: login.php');
       return;
   } else {

	function human_filesize($bytes, $decimals = 2) {
	    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
	    $factor = floor((strlen($bytes) - 1) / 3);
	    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	    }

	if(isset($_GET['dir'])) {
		$reqdir = $_GET['dir'];
		} else {
			$reqdir = ".";
		}
	$reqdir = filter_var($reqdir, FILTER_SANITIZE_SPECIAL_CHARS);
	
	$navItem = explode("/",$reqdir,2);
	$navItem = $navItem[0];
	
	$sortMethod = $_GET['sort'];

?>


<html>
        <head>
                <title>Media Server</title>
                <?php include_once('./rsrc/inc/includes.php'); ?>  

        </head>

        <body>

            <?php 
            	$activeNav = "browser";
            	include_once('./rsrc/inc/nav.php'); 
            ?>  

	        <div id="content">
	        
<!-- 	        	<a href="<? echo $_SESSION['url'] ?>&sort=modified"><i class="icon-list-ol"></i></a> -->

		        <table id="filelist">
					<?php

						$files = array();
						
							if(preg_match('/^\//', $reqdir)) {
								echo "<tr><td>Not allowed.  Rude.</td></tr>";
							} else {
						
								$dir = new DirectoryIterator($reqdir);
	
								foreach ($dir as $fileinfo) {
								    if($fileinfo->isDot()) continue;
								    if(preg_match('/^\./', $fileinfo->getFilename())) continue;
								    if(preg_match('/.php/', $fileinfo->getFilename())) continue;
								    if(preg_match('/sync/', $fileinfo->getFilename())) continue;
								    if(preg_match('/rsrc/', $fileinfo->getFilename())) continue;
								    if(preg_match('/sbprocessing/', $fileinfo->getFilename())) continue;
								    if(preg_match('/sickbeard/', $fileinfo->getFilename())) continue;
								    if(preg_match('/robots.txt/', $fileinfo->getFilename())) continue;
								    if(preg_match('/lost\+found/', $fileinfo->getFilename())) continue;
		
									if ($fileinfo->isFile()) {
									// If we see a filename, serve it without adding browser.php to the url 

										if ($sortMethod == 'modified') {
										// Sort by last modified
										   $files[$fileinfo->getMTime()] = "<tr><td><a href=\"" . $fileinfo->getPath() . "/" . $fileinfo->getFilename() . "\"><i class=\"icon-file-alt\"></i>" . $fileinfo->getFilename() . "</a></td><td><span class=\"button small\">" . human_filesize($fileinfo->getSize()) . "</span></td></tr>\n";
										} else {
										// Sort alphabetical
										   $files[$fileinfo->getFilename()] = "<tr><td><a href=\"" . $fileinfo->getPath() . "/" . $fileinfo->getFilename() . "\"><i class=\"icon-file-alt\"></i>" . $fileinfo->getFilename() . "</a></td><td><span class=\"button small\">" . human_filesize($fileinfo->getSize()) . "</span></td></tr>\n";
									}
									} else {
									// It's a folder!
									
										if ($sortMethod == 'modified') {
											//
											$files[$fileinfo->getMTime()] = "<tr><td><a href=\"" . "browser.php?dir=" . $fileinfo->getPath() . "/" . $fileinfo->getFilename() . "\"><i class=\"icon-folder-close\"></i>" . $fileinfo->getFilename() . "</a></td><td>&nbsp;</td></tr>\n";
										} else {
											// Sort alphabetical
											$files[$fileinfo->getFilename()] = "<tr><td><a href=\"" . "browser.php?dir=" . $fileinfo->getPath() . "/" . $fileinfo->getFilename() . "\"><i class=\"icon-folder-close\"></i>" . $fileinfo->getFilename() . "</a></td><td>&nbsp;</td></tr>\n";
											
										}
										
									}
								}
							
								if ($sortMethod == 'modified') {
									krsort($files);
								} else {
									ksort($files);
								}

								    foreach ($files as $tablerow) {
									    echo $tablerow;
									}
							}
							
							if (empty($files)) {
							    echo "<tr><td>Nothing here!</td><td>&nbsp;</td></tr>";
							}

					?>
		        </table>
	        </div>

	        <?php include_once('./rsrc/inc/widgets.php'); ?>  

        </body>
</html>

<?php
}
?>
