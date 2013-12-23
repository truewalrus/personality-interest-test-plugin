<?php 
    global $wpdb;
    $url = parse_url($_SERVER["REQUEST_URI"]);
    wp_parse_str($url["query"], $parsed_url);
	
	if($_POST['ptest_quiz_name_hidden'] == 'Y')
	{
		$quiz_name = $_POST['ptest_quiz_name_change'];
		ptest_update_quiz($parsed_url['id'], $quiz_name);
	}
	if($_POST['ptest_result_add_hidden'] == 'add')
	{
		$result = array('name'=>$_POST['ptest_result_name'], 'tags'=>$_POST['ptest_result_tags']);
		ptest_insert_result($parsed_url['id'], $result);
	}
	if($_POST['ptest_result_add_hidden'] == 'edit')
	{
		$result = array('name'=>$_POST['ptest_result_name'], 'tags'=>$_POST['ptest_result_tags']);
		$result_id = $_POST['ptest_result_id_hidden'];
		ptest_update_result($result_id, $result);
	}
	if($_POST['ptest_result_delete_hidden'] == 'Y')
	{
		$result_id = $_POST['ptest_result_id_hidden'];
		ptest_delete_result($result_id);
	}
	if($_POST['ptest_question_hidden'] == 'add')
	{
		$question = $_POST['ptest_question_question'];
		$question_id = ptest_insert_question($parsed_url['id'], $question);
		$answers = $_POST['ptest_answer_name'];
		$tags = $_POST['ptest_answer_tags'];
		$value = $_POST['ptest_answer_value'];
		
		$answer_array = array();
		
		for ($i=0; $i < count($answers); $i++){
			array_push($answer_array, (array("answer"=>$answers[$i], "tags"=>$tags[$i], "value"=>$value[$i])));
		}
		
		ptest_insert_answers($question_id, $answer_array);
	}
	if($_POST['ptest_question_hidden'] == 'edit')
	{
		
		$question = $_POST['ptest_question_question'];
		$question_id = $_POST['ptest_question_id_hidden'];
		ptest_update_question($question_id, $question);
		$answers = $_POST['ptest_answer_name'];
		$tags = $_POST['ptest_answer_tags'];
		$value = $_POST['ptest_answer_value'];
		
		$answer_array = array();
		
		for ($i=0; $i < count($answers); $i++){
			array_push($answer_array, (array("answer"=>$answers[$i], "tags"=>$tags[$i], "value"=>$value[$i])));
		}
		
		ptest_update_answers($question_id, $answer_array);
	}
	
    $quiz = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_quizzes WHERE id = " . $parsed_url['id']);
    $quiz = $quiz[0];
    $results_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_results WHERE quiz_id = " . $parsed_url['id']);
    $questions_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_questions WHERE quiz_id = " . $parsed_url['id']);
?>

<script type = "text/javascript">

	function editQuiz(){
		document.getElementById("edit-quiz").style.display="block";
		document.getElementById("add-result").style.display="none";
		document.getElementById("add-question").style.display="none";
		document.getElementById("ptest_quiz_name_change").focus();
	}
	
	function addNewResult(){
		document.getElementById("result-header").innerHTML = "Add Result";
		document.getElementById("ptest_result_add_hidden").value="add";
		document.getElementById("add-result").style.display="block";
		document.getElementById("edit-quiz").style.display="none";
		document.getElementById("add-question").style.display="none";
		document.getElementById("ptest_result_name").value = "";
		document.getElementById("ptest_result_id_hidden").value = "";
		document.getElementById("ptest_result_tags").value = "";
		document.getElementById("ptest_result_name").focus();
	}
	
	function editResult(id, name, tags){
		document.getElementById("result-header").innerHTML = "Edit Result";
		document.getElementById("ptest_result_add_hidden").value="edit";
		document.getElementById("add-result").style.display="block";
		document.getElementById("edit-quiz").style.display="none";
		document.getElementById("add-question").style.display="none";
		document.getElementById("ptest_result_name").value = name;
		document.getElementById("ptest_result_id_hidden").value = id;
		document.getElementById("ptest_result_tags").value = tags;
		document.getElementById("ptest_result_name").focus();
	}
	
	var answerCount = 0;
	
	// black magic
	function deleteAnswer(e) {		
		if (answerCount > 1) {
			answerCount--;
		
			var row = e.parentNode.parentNode;
			var table = document.getElementById("answers");
			
			table.removeChild(row);
			
			// huh?
			for (var i = 1; i < table.childNodes.length; i++) {
				table.childNodes[i].childNodes[0].innerHTML = (i) + ".";
			}
		}
	}
	
	function editQuestion(id, question) {
		var args = Array.prototype.slice.call(arguments, 2);
		
		document.getElementById("question-header").innerHTML = "Edit Question";
		document.getElementById("add-question").style.display="block";
		document.getElementById("add-result").style.display="none";
		document.getElementById("edit-quiz").style.display="none";
		document.getElementById("answers").innerHTML = "<tr><th></th><th>Answer</th><th>Tags</th><th>Value</th><th></th></tr>";
		answerCount = 0;
		
		document.getElementById("ptest_question_hidden").value = "edit";		
		document.getElementById("ptest_question_id_hidden").value = id;
		document.getElementById("ptest_question_question").value = question;
		
		for (var i = 0; i < args.length; i++) {
			answerCount++;
			var container = document.createElement("tr");
			
			var td = document.createElement("td");
			td.innerHTML = answerCount + ".";
			container.appendChild(td);
			
			var newAnswer = document.createElement("input");
			newAnswer.setAttribute("name", "ptest_answer_name[]");
			newAnswer.setAttribute("value", args[i][0]);
			var td = document.createElement("td");
			td.appendChild(newAnswer);
			container.appendChild(td);
			
			var newTags = document.createElement("input");
			newTags.setAttribute("name", "ptest_answer_tags[]");
			newTags.setAttribute("value", args[i][1]);
			td = document.createElement("td");
			td.appendChild(newTags);
			container.appendChild(td);
			
			var newValue = document.createElement("input");
			newValue.setAttribute("name", "ptest_answer_value[]");
			newValue.setAttribute("value", args[i][2]);
			td = document.createElement("td");
			td.appendChild(newValue);
			container.appendChild(td);
			
			var delBut = document.createElement("input");
			delBut.setAttribute("onclick", "deleteAnswer(this)");
			delBut.setAttribute("type", "button");
			delBut.setAttribute("value", "Delete");
			td = document.createElement("td");
			td.appendChild(delBut);
			container.appendChild(td);

			document.getElementById("answers").appendChild(container);
		}
	}
	
	function addClick(id, params) {
		var e = document.getElementById(id);
		
		e.setAttribute("onclick", "editQuestion(" + params + ")");
	}
	
	function addNewAnswer(){
		answerCount++;
		var container = document.createElement("tr");
		
		var td = document.createElement("td");
		td.innerHTML = answerCount + ".";
		container.appendChild(td);
		
		var newAnswer = document.createElement("input");
		newAnswer.setAttribute("name", "ptest_answer_name[]");
		var td = document.createElement("td");
		td.appendChild(newAnswer);
		container.appendChild(td);
		
		var newTags = document.createElement("input");
		newTags.setAttribute("name", "ptest_answer_tags[]");
		td = document.createElement("td");
		td.appendChild(newTags);
		container.appendChild(td);
		
		var newValue = document.createElement("input");
		newValue.setAttribute("name", "ptest_answer_value[]");
		td = document.createElement("td");
		td.appendChild(newValue);
		container.appendChild(td);
		
		var delBut = document.createElement("input");
		delBut.setAttribute("onclick", "deleteAnswer(this)");
		delBut.setAttribute("type", "button");
		delBut.setAttribute("value", "Delete");
		td = document.createElement("td");
		td.appendChild(delBut);
		container.appendChild(td);

		document.getElementById("answers").appendChild(container);
	}
	
	function addNewQuestion(){
		document.getElementById("question-header").innerHTML = "Add Result";
		document.getElementById("add-question").style.display="block";
		document.getElementById("add-result").style.display="none";
		document.getElementById("edit-quiz").style.display="none";
		document.getElementById("answers").innerHTML = "<tr><th></th><th>Answer</th><th>Tags</th><th>Value</th><th></th></tr>";
		document.getElementById("ptest_question_hidden").value = "add";
		document.getElementById("ptest_question_question").value = "";
		answerCount = 0;
		addNewAnswer();
	}

</script>

<div class = "ptest-container">

	<a href = "<?php echo remove_query_arg( array( 'edit', 'id' ) ); ?>"> Back </a>

	<div class = "ptest-display-left">
		<h2>Quiz Information</h2>
		<table class = "ptest-quiz-table">
			<tr>
				<th>Quiz Name</th>
				<th>Short Code</th>
				<th>Options</th>
			</tr>
			<tr>
				<th><?php echo $quiz->name; ?></th>
				<th> <?php echo "[ptest id =" . $quiz->id . "]";?></th>
				<th> <button onclick = "editQuiz()">Edit Name</button>
			</tr>
		</table>

		<h2>Results</h2> <button onclick = "addNewResult()">Add New</button>
		<table class = "ptest-quiz-table">
			<tr>
				<th>#</th>
				<th>Result Name</th>
				<th>Tags</th>
				<th>Options</th>
			</tr>
		<?php 
		foreach($results_list as $result){?>
			<tr>
				<td><?php echo $result->id; ?></td>
				<td><?php echo $result->name; ?></td>
				<td><?php echo $result->tag; ?></td>
				<td><button onclick = "editResult(<?php  echo $result->id . ", '" . $result->name . "', '" . $result->tag . "'"  ?> )">Edit</button> 
				<form name = "result-delete" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post"  style = "display: inline">
					<input type = "hidden" name = "ptest_result_delete_hidden" value = "Y">
					<input type = "hidden" name = "ptest_result_id_hidden" value = "<?php echo $result->id ?>">
					<input type = "submit" value = "Delete">
				</form></td>
				
			</tr>
		<?php } ?>
		</table>

		<h2>Questions</h2> <button onclick = "addNewQuestion()">Add New</button>

		<?php $count = 0;
		foreach($questions_list as $question) {
			 $count++;
			 echo $count . ". " . $question->question;?>
			 <button id="question<?php echo $question->id ?>">Edit</button> 
				<form name = "result-delete" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post" style = "display: inline">
					<input type = "hidden" name = "ptest_result_delete_hidden" value = "Y">
					<input type = "hidden" name = "ptest_result_id_hidden" value = "<?php echo $result->id ?>">
					<input type = "submit" value = "Delete">
				</form>
		<?php
			$click_params = "{$question->id}, \"{$question->question}\"";
			 echo "</br>";
			 $answers_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_answers WHERE question_id = " . $question->id);
			 $ans_count = 0;
			 foreach($answers_list as $answer){
				$ans_count++;
				echo $ans_count . ". " .$answer->answer . " (" . $answer->tag . ") [" . $answer->value . "]";
				echo "</br>";
				
				$click_params .= ", [\"{$answer->answer}\", \"{$answer->tag}\", \"{$answer->value}\"]";
				
				
			 }
			 echo "<script type='text/javascript'> addClick(\"question" . $question->id . "\", '" . $click_params . "');</script>";
		} ?>
	</div>

	<div class = "ptest-display-right">
		<div id = "edit-quiz" style = "display: none">
			<h2>Edit Quiz</h2>
			<form name = "quiz_mod" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
				<input type = "hidden" name = "ptest_quiz_name_hidden" value = "Y">
				Quiz Name: <input type = "text" id = "ptest_quiz_name_change" name = "ptest_quiz_name_change" width = "20" value = <?php echo $quiz->name; ?> >
				<input type = "submit" value = "Submit">
			</form>
		</div>
		
		<div id = "add-result" style = "display: none">
			<h2 id = "result-header">Add Result</h2>
			<form name = "result" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
				<input type = "hidden" name = "ptest_result_add_hidden" id = "ptest_result_add_hidden" value = "edit">
				<input type = "hidden" name = "ptest_result_id_hidden" id = "ptest_result_id_hidden">
				Result: <input type = "text" name = "ptest_result_name" id = "ptest_result_name" width = "20">
				Tags: <input type = "text" name = "ptest_result_tags" id = "ptest_result_tags" width = "20">
				<input type = "submit" value = "Submit">
			</form>
		</div>
		
		<div id = "add-question" style = "display: none">
			<h2 id = "question-header">Add Question</h2>
			<form name = "ques_add" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
				<input type = "hidden" name = "ptest_question_hidden" id = "ptest_question_hidden" value = "edit">
				<input type = "hidden" name = "ptest_question_id_hidden" id = "ptest_question_id_hidden">
				Question: <input type = "text" name = "ptest_question_question" id = "ptest_question_question" width = "20">
				<button type = "button" onclick = "addNewAnswer()">Add An Answer</button>
				<table id = "answers"></table>
				<input type = "submit" value = "Submit">
			</form>
		
		</div>
	</div>
</div>
