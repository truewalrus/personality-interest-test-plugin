<div class = "wrap">
<!----------ROUTER PAGE FOR CUSTOM PAGES----------->
	<?php 
		$url = parse_url($_SERVER["REQUEST_URI"]);
		wp_parse_str($url["query"], $router);
		if($router['edit'] >= "1"){
			include('personality-test-edit.php');
		}
		else{
			include('personality-test-list.php');
		}
	?>
</div>
	