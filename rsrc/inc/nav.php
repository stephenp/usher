<!-- To do: convert host names to php var? -->
	        <nav>
	        	<ol>
	        		<li><a href="index.php"<? if($activeNav == "home") echo " class=\"current\"" ?>><i class="fa fa-home"></i></a></li>
	        		<li><a href="browser.php?sort=default"<? if($activeNav == "browser") echo " class=\"current\"" ?>><i class="fa fa-hdd-o"></i></a></li>
	        		<li><a href="http://media.stephenpontes.com:9091"><i class="fa fa-cogs"></i></a></li>
	        		<li><a href="http://media.stephenpontes.com:32400/web" id="plexControls"><i class="fa fa-chevron-right"></i></a></li>
	        		<li><a href="http://media.stephenpontes.com:8081"><i class="fa fa-magic"></i></a></li>
	        		<li><a href="#" id="bgSwap"><i class="fa fa-picture-o"></i></a></li>
	        	</ol>
	        </nav>
