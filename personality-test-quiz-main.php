<div class = "wrap">
<!----------ROUTER PAGE FOR CUSTOM PAGES----------->
	<?php 
		$url = parse_url($_SERVER["REQUEST_URI"]);
		wp_parse_str($url["query"], $router);
		if($router['edit'] == "quiz"){
			include('personality-test-edit.php');
		}
		elseif ($router['edit'] == "results"){
			include('personality-test-results.php');
		}
		else{
			include('personality-test-list.php');
		}
	?>
</div>
	