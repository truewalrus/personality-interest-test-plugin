<div class = 'wrap'>
	<form name = "temp" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		<input type = "hidden" name = "ptest_hidden" value = "Y">
		Question: <input type = "text" name = "ptest_question" width = "20">
		A1: <input type = "text" name = "ptest_answer_0" width = "20">
		A2: <input type = "text" name = "ptest_answer_1" width = "20">
		A3: <input type = "text" name = "ptest_answer_3" width = "20">
		
		<input type = "submit" value = "Submit">
	</form>
	
	
	<?php
		global $wpdb;
		$questions_sql = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_questions");
		
		?><table>
		<tr>
			<th>#</th>
			<th>Question</th>
		</tr>
		
		<?php
		$order = 0;
		foreach ( $questions_sql as $q){
			$order++;
			?><tr>
				<td><?php echo $order; ?></td> 
				<td><?php echo $q->question; ?></td> 
			</tr><?php
		}?>
		</table>
	<?php
	?>

</div>

<?php
	if ($_POST['ptest_hidden'] == 'Y'){
		$question = $_POST['ptest_question'];
		$answers = array($_POST['ptest_answer_0'], $_POST['ptest_answer_1'], $_POST['ptest_answer_2']);
		$question_id = ptest_insert_question($question);
		ptest_insert_answer($question_id, $answers);
		
	}
?>