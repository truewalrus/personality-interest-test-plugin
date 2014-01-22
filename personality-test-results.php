<?php 
    global $wpdb;
    $url = parse_url($_SERVER["REQUEST_URI"]);
    wp_parse_str($url["query"], $parsed_url);
	
	if($_POST['ptest_edit_result_page'] == 'Y') {
		$data = array( 'results_page' => $_POST['ptest_results_page'] );
		$wpdb->update($wpdb->prefix . "ptest_quizzes", $data, array('id' => $parsed_url['id']));
	}
	
	$quiz = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_quizzes WHERE id = " . $parsed_url['id']);
?>

<script type = "text/javascript">
	var originalResultsPage = "<?php echo preg_replace( "~[\r\n]+~", "\\n", $quiz[0]->results_page ); ?>";	

	function resetChanges(){
		document.getElementById('ptest-results-page').value = originalResultsPage;
	}
	
</script>

<div class = "ptest-container">
<div class = "ptest-stacking-container">
	<div class = "ptest-display-top">
		<a href = "<?php echo add_query_arg( array('edit' => 'quiz'), $_SERVER["REQUEST_URI"] ); ?>"> Back </a>
		<h2>Quiz Results Page</h2>
		<img src="<?php echo plugins_url( "images/dog.jpg", __FILE__ ); ?>">
		<form name = "result_page_edit" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
			<input type="hidden" name="ptest_edit_result_page" value="Y">
			<textarea class="ptest-results-page-edit" name="ptest_results_page" id="ptest-results-page"><?php echo stripslashes( htmlspecialchars( $quiz[0]->results_page ) ); ?></textarea>
			<input class = "ptest-form-submit" type = "submit" value = "Save Changes">
			<input class = "ptest-delete-item" type="button" onclick="resetChanges()" value="Reset">
		</form>
	</div>
</div>
</div>