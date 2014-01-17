<?php 
    global $wpdb;
    $url = parse_url($_SERVER["REQUEST_URI"]);
    wp_parse_str($url["query"], $parsed_url);
?>

<script type = "text/javascript">

	function removeHover(){
		document.getElementById('ptest-hover').style.display = "none";
		document.getElementById('ptest-hidden-hover').style.display = "none";
	}
	
</script>

<div class = "ptest-container">
<div class = "ptest-stacking-container">
	<div class = "ptest-display-top">
		<a href = "<?php echo add_query_arg( array('edit' => 'quiz'), $_SERVER["REQUEST_URI"] ); ?>"> Back </a>
		<h2>Quiz Results Page</h2>
		<textarea class="ptest-results-page-edit">Giant text area</textarea>
	</div>
</div>
</div>