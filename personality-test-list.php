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
		document.getElementById('ptest-add-quiz').style.display = "block";
		document.getElementById('ptest-display-hidden').style.display = "block";
	}
	
	function removeHover(){
		document.getElementById('ptest-add-quiz').style.display = "none";
		document.getElementById('ptest-display-hidden').style.display = "none";
	}
</script>

<div class = "ptest-container">
	<div class = "ptest-stacking-container">
		<div class = "ptest-display-top">
		<h2>Quiz List <button class = "ptest-add-symbol" onclick = "addNewQuiz()" title = "Add a new quiz">+</button></h2>
		<?php  	
			/**********LIST ALL EDITABLE QUIZZES************/
			global $wpdb;
			$quiz_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_quizzes");
			$quiz_count = 1;
			?>
			<table class = "ptest-quiz-table">
					<tr>
						<th style = "max-width: 5%; width: 5%;">#</th>
						<th style = "max-width: 50%; width: 50%;">Quiz Name</th>
						<th style = "max-width: 20%; width: 20%;">Short Code</th>
						<th style = "max-with: 15%; width: 15%;">Options</th>
					</tr>
			<?php foreach($quiz_list as $quiz){
				?><tr>
					<td> <?php echo $quiz_count++; ?></td>
					<td> <?php echo $quiz->name; ?></td>
					<td> <?php echo "[ptest id=" . $quiz->id . "]"; ?></td>
					<td> 
						<?php 
						$link_url = add_query_arg( array('edit' => 'quiz', 'id' => $quiz->id), $_SERVER["REQUEST_URI"] );?>	
						<a class = "ptest-modify-link" href = "<?php echo $link_url; ?>">Modify</a>
						<span class = "ptest-separator">|</span>
						<form onsubmit = "return confirm('Are you sure you want to delete?');" name = "ptest-quiz-delete" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post"  style = "display: inline">
							<input type = "hidden" name = "ptest_quiz_delete_hidden" value = "Y">
							<input type = "hidden" name = "ptest_quiz_id_hidden" value = "<?php echo $quiz->id ?>">
							<input class = "ptest-delete-submit" type = "submit" value = "Delete">
						</form></td>
				</tr>
			<?php } ?>
			</table>
			<?php
			
		?>
		</div>

		<div class = "ptest-edit-hover" id = "ptest-add-quiz"  style = "display: none">
			<h2 class = "ptest-edit-h2">Add New Quiz</h2>
			<div><span class = "ptest-helper">This will add a quiz to your list of quizzes. You can then select Modify to add questions and results to your quiz as well as change its name.</span></div>
			<br>
			<form name = "ptest_quiz_add" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
				<input type = "hidden" name = "ptest_quiz_name_hidden" value = "Y">
				<div class = "ptest-form-spacer">Quiz Name:</div> <input type = "text" placeholder = "Quiz Name" class = "ptest-form-input-spacer" name = "ptest_quiz_name_add">
				<input class = "ptest-form-submit" type = "submit" value = "Save">
			</form>
			<br>
		</div>
		
		<div class = "ptest-display-hidden-hover-closer" id = "ptest-display-hidden" onclick = "removeHover()"></div>
	</div>
</div>
