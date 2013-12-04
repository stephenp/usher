<?php

session_start();

// All backgrounds via unsplash.com

if(!isset($_SESSION['sessionBackground'])){

	$fileInfo = "";
	$bgArray = array();

	foreach (new DirectoryIterator('rsrc/img/backgrounds') as $fileInfo) {
	    if($fileInfo->isDot()) continue;
	    $bgArray[] = $fileInfo->getFilename();
	}

	$_SESSION['sessionBackground'] = $bgArray[rand(0,(count($bgArray) - 1))];


}
	echo "<style type=\"text/css\">body { background-image: url(\"/rsrc/img/backgrounds/" . $_SESSION['sessionBackground'] . "\");</style>";

?>