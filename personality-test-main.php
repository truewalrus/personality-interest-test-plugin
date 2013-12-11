<div class = 'wrap'>
	
	<!-----Testing Quiz Functions --------->
	<h2>Quiz Functions</h2>
	<form name = "quiz_add" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		Insert: <input type = "hidden" name = "ptest_quiz1_hidden" value = "Y">
		Quiz Name: <input type = "text" name = "ptest_quiz_name" width = "20">
		<input type = "submit" value = "Submit"> 
	</form>
	
	</br>
	
	<form name = "quiz_mod" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		<input type = "hidden" name = "ptest_quiz2_hidden" value = "Y">
		Update: Quiz Name: <input type = "text" name = "ptest_quiz_name_change" width = "20">
		ID: <input type = "text" name = "ptest_quiz_id" width = "20">
		<input type = "submit" value = "Submit">
	</form>
	
	</br>
	
	<form name = "quiz_delete" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		<input type = "hidden" name = "ptest_quiz3_hidden" value = "Y">
		Delete: ID: <input type = "text" name ="ptest_quiz_id_delete" width = "20">
		<input type = "submit" value = "Submit">
	</form>

	<!---------End Testing Quiz Functions----->
	
	<!---------RESULT TESTING------->
	<h2>Result Functions</h2>
	<form name = "result_add" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		<input type = "hidden" name = "ptest_result1_hidden" value = "Y">
		Insert: Result: <input type = "text" name = "ptest_result_name" width = "20">
		Quiz ID: <input type = "text" name = "ptest_result_quiz_id" width = "20">
		Tags: <input type = "text" name = "ptest_result_tags" width = "20">
		<input type = "submit" value = "Submit">
	</form>
	
	<form name = "result_mod" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		<input type = "hidden" name = "ptest_result2_hidden" value = "Y">
		Update: Result: <input type = "text" name = "ptest_result_name_change" width = "20">
		ID:  <input type = "text" name = "ptest_result_id" width = "20">
		Tags: <input type ="text" name = "ptest_result_tags_change" width = "20">
		<input type = "submit" value = "Submit">
	</form>
	
	<form name = "result_del" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		Delete: <input type = "hidden" name = "ptest_result3_hidden" value = "Y">
		ID:  <input type = "text" name = "ptest_result_id_delete" width = "20">
		<input type = "submit" value = "Submit">
	</form>
	<!---- END RESULT TESTING --------->

	<!--------QUESTION TESTING--------->
	<h2>Question Functions</h2>
	<form name = "ques_add" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		Insert: <input type = "hidden" name = "ptest_question1_hidden" value = "Y">
		Question: <input type = "text" name = "ptest_question_question" width = "20">
		Quiz ID: <input type = "text" name = "ptest_question_quiz_id" width = "20">
		<input type = "submit" value = "Submit">
	</form>
	
	<form name = "ques_mod" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		Update: <input type = "hidden" name = "ptest_question2_hidden" value = "Y">
		Question: <input type = "text" name = "ptest_question_question_change" width = "20">
		Question ID: <input type = "text" name = "ptest_question_question_id" width = "20">
		<input type = "submit" value = "Submit">
	</form>
	
	<form name = "ques_del" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		Delete: <input type = "hidden" name = "ptest_question3_hidden" value = "Y">
		ID:  <input type = "text" name = "ptest_question_id_delete" width = "20">
		<input type = "submit" value = "Submit">
	</form>
	<!--------END QUESTION TESTING------->
	
	<!--------ANSWERS TESTING---------->
	<h2>Answer Functions</h2>
	<form name = "ans_add" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		Insert: <input type = "hidden" name = "ptest_answer1_hidden" value = "Y">
		Answer1: <input type = "text" name = "ptest_answer_1" width = "20">
		Tag1:<input type = "text" name = "ptest_answer_tag_1" width = "20">
		</br>
		Answer2:<input type = "text" name = "ptest_answer_2" width = "20">
		Tag2:<input type = "text" name = "ptest_answer_tag_2" width = "20">
		</br>
		Question ID: <input type = "text" name = "ptest_answer_q_id" width = "20">
		<input type = "submit" value = "Submit">
	</form>
	
	<form name = "ans_mod" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		Update: <input type = "hidden" name = "ptest_answer2_hidden" value = "Y">
		Answer1: <input type = "text" name = "ptest_answer_change_1" width = "20">
		Tag1:<input type = "text" name = "ptest_answer_tag_change_1" width = "20">
		</br>
		Answer2:<input type = "text" name = "ptest_answer_change_2" width = "20">
		Tag2:<input type = "text" name = "ptest_answer_tag_change_2" width = "20">
		</br>
		Question ID: <input type = "text" name = "ptest_answer_q_change_id" width = "20">
		<input type = "submit" value = "Submit"> Currently broken: updates all answers to second answer -- need to find workaround or change to singular updating
	</form>
	
	<form name = "ans_del" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
		Delete: <input type = "hidden" name = "ptest_answer3_hidden" value = "Y">
		Answer ID: <input type ="text" name = "ptest_answer_delete_id" width = "20">
		<input type = "submit" value = "Submit">
	</form>
	<!---END ANSWERS TESTING---->
	
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
	//quiz func
	if ($_POST['ptest_quiz1_hidden'] == 'Y'){
		$quiz_name = $_POST['ptest_quiz_name'];
		echo ptest_insert_quiz($quiz_name);
	}
	
	if ($_POST['ptest_quiz2_hidden'] == 'Y'){
		$quiz_name = $_POST['ptest_quiz_name_change'];
		$quiz_id = $_POST['ptest_quiz_id'];
		ptest_update_quiz($quiz_id, $quiz_name);
	}
	
	if ($_POST['ptest_quiz3_hidden'] == 'Y'){
		$quiz_id = $_POST['ptest_quiz_id_delete'];
		ptest_delete_quiz($quiz_id, $quiz_name);
	}
	
	//result func
	if ($_POST['ptest_result1_hidden'] == 'Y'){
		$result = array('name'=>$_POST['ptest_result_name'], 'tags'=>$_POST['ptest_result_tags']);
		$quiz_id = $_POST['ptest_result_quiz_id'];
		echo ptest_insert_result($quiz_id, $result);
	}
	
	if ($_POST['ptest_result2_hidden'] == 'Y'){
		$result = array('name'=>$_POST['ptest_result_name_change'], 'tags'=>$_POST['ptest_result_tags_change']);
		$result_id = $_POST['ptest_result_id'];
		ptest_update_result($result_id, $result);
	}
	
		if ($_POST['ptest_result3_hidden'] == 'Y'){
		$result_id = $_POST['ptest_result_id_delete'];
		ptest_delete_result($result_id);
	}
	
	//question func
	if ($_POST['ptest_question1_hidden'] == 'Y'){
		$question = $_POST['ptest_question_question'];
		$quiz_id = $_POST['ptest_question_quiz_id'];
		echo ptest_insert_question($quiz_id, $question);
	}
	
	if ($_POST['ptest_question2_hidden'] == 'Y'){
		$question = $_POST['ptest_question_question_change'];
		$question_id = $_POST['ptest_question_question_id'];
		ptest_update_question($question_id, $question);
	}
	
	if ($_POST['ptest_question3_hidden'] == 'Y'){
		$question_id = $_POST['ptest_question_id_delete'];
		ptest_delete_question($question_id);
	}
	
	//answer func
	if ($_POST['ptest_answer1_hidden'] == 'Y'){
		$answer1 = array('answer'=>$_POST['ptest_answer_1'], 'tags'=>$_POST['ptest_answer_tag_1']);
		$answer2 = array('answer'=>$_POST['ptest_answer_2'], 'tags'=>$_POST['ptest_answer_tag_2']);
		$answers = array($answer1, $answer2);
		$question_id = $_POST['ptest_answer_q_id'];
		echo ptest_insert_answers($question_id, $answers);
	}
	
	if ($_POST['ptest_answer2_hidden'] == 'Y'){
		$answer1 = array('answer'=>$_POST['ptest_answer_change_1'], 'tags'=>$_POST['ptest_answer_tag_change_1']);
		$answer2 = array('answer'=>$_POST['ptest_answer_change_2'], 'tags'=>$_POST['ptest_answer_tag_change_2']);
		$answers = array($answer1, $answer2);
		$question_id = $_POST['ptest_answer_q_change_id'];
		ptest_update_answers($question_id, $answers);
	}
	
	if ($_POST['ptest_answer3_hidden'] = 'Y'){
		$answer_id = $_POST['ptest_answer_delete_id'];
		ptest_delete_answer($answer_id);
	}
	
	

	
?>