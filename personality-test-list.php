<?php
	if($_POST['ptest_quiz_name_hidden'] == 'Y')
	{
		$quiz_name = $_POST['ptest_quiz_name_add'];
		ptest_insert_quiz($quiz_name);
	}
	
	if($_POST['ptest_quiz_delete_hidden'] == 'Y')
	{
		$quiz_id = $_POST['ptest_quiz_id_hidden'];
		ptest_delete_quiz($quiz_id);
	}
?>

<script type = "text/javascript">
	function addNewQuiz(){
		document.getElementById('add-quiz').style.display = "block";
	}
</script>

<div class = "ptest-display-left">
<button onclick = "addNewQuiz()">Add New</button>
<?php  	
	/**********LIST ALL EDITABLE QUIZZES************/
	global $wpdb;
	$quiz_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_quizzes");
	$quiz_count = 1;
	?>
	<table>
			<tr>
				<th>#</th>
				<th>Quiz Name</th>
				<th>Short Code</th>
				<td>Options</th>
			</tr>
	<?php foreach($quiz_list as $quiz){
		?><tr>
			<td> <?php echo $quiz_count++; ?></td>
			<td> <?php echo $quiz->name; ?></td>
			<td> <?php echo "[ptest id=" . $quiz->id . "]"; ?></td>
			<td> 
				<?php 
				$link_url = add_query_arg( array('edit' => '1', 'id' => $quiz->id), $_SERVER["REQUEST_URI"] );?>	
				<a href = "<?php echo $link_url; ?>"> Check </a>
				<form name = "quiz-delete" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post"  style = "display: inline">
					<input type = "hidden" name = "ptest_quiz_delete_hidden" value = "Y">
					<input type = "hidden" name = "ptest_quiz_id_hidden" value = "<?php echo $quiz->id ?>">
					<input type = "submit" value = "Delete">
				</form></td>
		</tr>
	<?php } ?>
	</table>
	<?php
	
?>
</div>

<div class = "ptest-display-right">
	<div id = "add-quiz" style = "display: none">
		<h2>Add New Quiz</h2>
		<form name = "quiz_add" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
			<input type = "hidden" name = "ptest_quiz_name_hidden" value = "Y">
			Quiz Name: <input type = "text" name = "ptest_quiz_name_add" width = "20">
			<input type = "submit" value = "Submit">
		</form>
	</div>
</div>