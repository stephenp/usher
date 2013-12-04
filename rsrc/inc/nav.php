<!-- To do: convert host names to php var? -->
	        <nav>
	        	<ol>
	        		<li><a href="index.php"<? if($activeNav == "home") echo " class=\"current\"" ?>><i class="icon-home"></i></a></li>
	        		<li><a href="browser.php?sort=default"<? if($activeNav == "browser") echo " class=\"current\"" ?>><i class="icon-hdd"></i></a></li>
	        		<li><a href="http://media.stephenpontes.com:9091"><i class="icon-cogs"></i></a></li>
	        		<li><a href="http://media.stephenpontes.com:32400/web" id="plexControls"><i class="icon-chevron-right"></i></a></li>
	        		<li><a href="http://media.stephenpontes.com:8081"><i class="icon-magic"></i></a></li>
	        		<li><a href="#" id="bgSwap"><i class="icon-picture"></i></a></li>
	        	</ol>
	        </nav>
