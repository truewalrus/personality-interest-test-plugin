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
		$result = array('name'=>$_POST['ptest_result_name'], 'tags'=>$_POST['ptest_result_tags'], 'description'=>$_POST['ptest_result_description']);
		ptest_insert_result($parsed_url['id'], $result);
	}
	if($_POST['ptest_result_add_hidden'] == 'edit')
	{
		$result = array('name'=>$_POST['ptest_result_name'], 'tags'=>$_POST['ptest_result_tags'], 'description'=>$_POST['ptest_result_description']);
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
	if($_POST['ptest_question_delete_hidden'] == 'Y')
	{
		$question_id = $_POST['ptest_question_id_hidden'];
		ptest_delete_question($question_id);
	}
	
    $quiz = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_quizzes WHERE id = " . $parsed_url['id']);
    $quiz = $quiz[0];
    $results_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_results WHERE quiz_id = " . $parsed_url['id']);
    $questions_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_questions WHERE quiz_id = " . $parsed_url['id']);
?>

<script type = "text/javascript">

	/*function confirmDelete(form){
		var del = confirm("You are about to delete an item. Are you sure?");
		if (del == true){
			form.submit();
		}
		else{
			
		}
	}*/
	function removeHover(){
		document.getElementById('ptest-hover').style.display = "none";
		document.getElementById('ptest-hidden-hover').style.display = "none";
		document.getElementById('ptest-question-hover').style.display = "none";
	}
	function editQuiz(){
		document.getElementById('ptest-hover').style.display = "block";
		document.getElementById('ptest-hidden-hover').style.display = "block";
		document.getElementById("ptest-edit-quiz").style.display="block";
		document.getElementById("ptest-add-result").style.display="none";
		document.getElementById("ptest-add-question").style.display="none";
		document.getElementById("ptest_quiz_name_change").focus();
	}
	
	function addNewResult(){
		document.getElementById('ptest-question-hover').style.display = "block";
		document.getElementById('ptest-hidden-hover').style.display = "block";
		document.getElementById("result-header").innerHTML = "Add Result";
		document.getElementById("ptest-helper-results").innerHTML = "Add a new Result to your quiz.  The name of the Result is how it will appear at the end of your quiz.<br> Results match with answers by matching tags and counting values. A result can have multiple comma separated tags (ex: tag1, tag2, tag3).";
		document.getElementById("ptest_result_add_hidden").value="add";
		document.getElementById("ptest-add-result").style.display="block";
		document.getElementById("ptest-edit-quiz").style.display="none";
		document.getElementById("ptest-add-question").style.display="none";
		document.getElementById("ptest_result_name").value = "";
		document.getElementById("ptest_result_id_hidden").value = "";
		document.getElementById("ptest_result_tags").value = "";
		document.getElementById("ptest_result_name").focus();
		document.getElementById("ptest_result_description").value = "";
	}
	
	function editResult(id, name, tags, description){
		document.getElementById('ptest-question-hover').style.display = "block";
		document.getElementById('ptest-hidden-hover').style.display = "block";
		document.getElementById("result-header").innerHTML = "Edit Result";
		document.getElementById("ptest-helper-results").innerHTML = "Edit a result's name or tags.";
		document.getElementById("ptest_result_add_hidden").value="edit";
		document.getElementById("ptest-add-result").style.display="block";
		document.getElementById("ptest-edit-quiz").style.display="none";
		document.getElementById("ptest-add-question").style.display="none";
		document.getElementById("ptest_result_name").value = name;
		document.getElementById("ptest_result_id_hidden").value = id;
		document.getElementById("ptest_result_tags").value = tags;
		document.getElementById("ptest_result_name").focus();
		document.getElementById("ptest_result_description").value = description;
	}
	
	var answerCount = 0;
	
	// black magic
	function deleteAnswer(e) {		
		if (answerCount > 1) {
			answerCount--;
		
			var row = e.parentNode.parentNode;
			var table = document.getElementById("ptest-answers-form");
			
			table.removeChild(row);
			
			// huh?
			for (var i = 0; i < table.childNodes.length; i++) {
				table.childNodes[i].childNodes[0].innerHTML = (i+1) + ".";
			}
		}
	}
	
	function editQuestion(id, question) {
		var args = Array.prototype.slice.call(arguments, 2);
		
		document.getElementById('ptest-helper-questions').innerHTML = "Edit a question in your quiz."
		document.getElementById('ptest-question-hover').style.display = "block";
		document.getElementById('ptest-hidden-hover').style.display = "block";
		document.getElementById("ptest-question-header").innerHTML = "Edit Question";
		document.getElementById("ptest-add-question").style.display="block";
		document.getElementById("ptest-add-result").style.display="none";
		document.getElementById("ptest-edit-quiz").style.display="none";
		document.getElementById("ptest-answers-form").innerHTML = "";
		answerCount = 0;
		
		document.getElementById("ptest_question_hidden").value = "edit";		
		document.getElementById("ptest_question_id_hidden").value = id;
		document.getElementById("ptest_question_question").value = question;
		document.getElementById("ptest_question_question").focus();
		
		for (var i = 0; i < args.length; i++) {
			answerCount++;
			var container = document.createElement("div");
			container.className = "ptest-answers-box";
			
			var answerText = document.createElement("div");
			answerText.innerHTML = answerCount + ".";
			answerText.className = "ptest-form-spacer";
			container.appendChild(answerText);
			
			var answerInput = document.createElement("input");
			answerInput.required = true;
			answerInput.type = "text"
			answerInput.className = "ptest-form-answer-spacer";
			answerInput.setAttribute("name", "ptest_answer_name[]");
			answerInput.setAttribute("value", args[i][0]);
			container.appendChild(answerInput);
			
			var br = document.createElement("br");
			container.appendChild(br);
		
			var answerTags = document.createElement("div");
			answerTags.innerHTML = "Tags:";
			answerTags.className = "ptest-form-spacer";
			container.appendChild(answerTags);
			
			var tagsInput = document.createElement("input");
			tagsInput.required = true;
			tagsInput.setAttribute("type", "text");
			tagsInput.className = "ptest-form-answer-tags-spacer";
			tagsInput.setAttribute("name", "ptest_answer_tags[]");
			tagsInput.setAttribute("value", args[i][1]);
			container.appendChild(tagsInput);
			
			var answerValue = document.createElement("div");
			answerValue.innerHTML = "Value:";
			answerValue.className = "ptest-form-spacer";
			container.appendChild(answerValue);
			
			var valueInput = document.createElement("input");
			valueInput.required = true;
			valueInput.type = "text";
			valueInput.placeholder = "Point Value";
			valueInput.className = "ptest-form-answer-value-spacer";
			valueInput.setAttribute("name", "ptest_answer_value[]");
			valueInput.setAttribute("value", args[i][2]);
			container.appendChild(valueInput);
			
			var newBR = document.createElement("br");
			container.appendChild(newBR);
			
			var spacer = document.createElement("div");
			spacer.style.width = "90.2%";
			spacer.style.textAlign = "right";
			
			var delBut = document.createElement("input");
			delBut.setAttribute("onclick", "deleteAnswer(this)");
			delBut.setAttribute("type", "button");
			delBut.setAttribute("value", "Delete");
			delBut.setAttribute("class", "ptest-delete-item");
			spacer.appendChild(delBut);
			container.appendChild(spacer);

			document.getElementById("ptest-answers-form").appendChild(container);
		}
	}
	
	function addClick(id, params) {
		var e = document.getElementById(id);
		
		e.setAttribute("onclick", "editQuestion(" + params + ")");
	}
	
	function addNewAnswer(){
		answerCount++;
		var container = document.createElement("div");
		container.className = "ptest-answers-box";

		var answerText = document.createElement("div");
		answerText.innerHTML = answerCount + ".";
		answerText.className = "ptest-form-spacer";
		container.appendChild(answerText);
		
		var answerInput = document.createElement("input");
		answerInput.required = true;
		answerInput.placeholder = "The Answer";
		answerInput.type = "text"
		answerInput.className = "ptest-form-answer-spacer";
		answerInput.setAttribute("name", "ptest_answer_name[]");
		container.appendChild(answerInput);
		
		var br = document.createElement("br");
		container.appendChild(br);
		
		var answerTags = document.createElement("div");
		answerTags.innerHTML = "Tags:";
		answerTags.className = "ptest-form-spacer";
		container.appendChild(answerTags);
		
		var tagsInput = document.createElement("input");
		tagsInput.required = true;
		tagsInput.setAttribute("type", "text");
		tagsInput.placeholder = "tag1, tag2";
		tagsInput.className = "ptest-form-answer-tags-spacer";
		tagsInput.setAttribute("name", "ptest_answer_tags[]");
		container.appendChild(tagsInput);
		
		var answerValue = document.createElement("div");
		answerValue.innerHTML = "Value:";
		answerValue.className = "ptest-form-spacer";
		container.appendChild(answerValue);
		
		var valueInput = document.createElement("input");
		valueInput.required = true;
		valueInput.type = "text";
		valueInput.placeholder = "Point Value";
		valueInput.className = "ptest-form-answer-value-spacer";
		valueInput.setAttribute("name", "ptest_answer_value[]");
		container.appendChild(valueInput);
		
		var newBR = document.createElement("br");
		container.appendChild(newBR);
		
		var spacer = document.createElement("div");
		spacer.style.width = "90.2%";
		spacer.style.textAlign = "right";
		
		var delBut = document.createElement("input");
		delBut.setAttribute("onclick", "deleteAnswer(this)");
		delBut.setAttribute("type", "button");
		delBut.setAttribute("value", "Delete");
		delBut.setAttribute("class", "ptest-delete-item");
		spacer.appendChild(delBut);
		container.appendChild(spacer);

		document.getElementById("ptest-answers-form").appendChild(container);
	}
	
	function addNewQuestion(){
		document.getElementById('ptest-helper-questions').innerHTML = "Add a new question to your quiz."
		document.getElementById('ptest-question-hover').style.display = "block";
		document.getElementById('ptest-hidden-hover').style.display = "block";
		document.getElementById("ptest-question-header").innerHTML = "Add Question";
		document.getElementById("ptest-add-question").style.display="block";
		document.getElementById("ptest-add-result").style.display="none";
		document.getElementById("ptest-edit-quiz").style.display="none";
		document.getElementById("ptest-answers-form").innerHTML = '';
		document.getElementById("ptest_question_hidden").value = "add";
		document.getElementById("ptest_question_question").value = "";
		document.getElementById("ptest_question_question").focus();
		answerCount = 0;
		addNewAnswer();
	}

</script>

<div class = "ptest-container">
<div class = "ptest-stacking-container">
	<div class = "ptest-display-top">
		<a title = "Return to the list of quizzes." href = "<?php echo remove_query_arg( array( 'edit', 'id' ) ); ?>"> Back </a>
		<h2>Quiz Information</h2>
		<table class = "ptest-quiz-table">
			<tr>
				<th>Quiz Name</th>
				<th>Short Code</th>
				<th>Options</th>
			</tr>
			<tr>
				<th style = "max-width: 55%; width: 55%;"><?php echo $quiz->name; ?></th>
				<th> <?php echo "[ptest id =" . $quiz->id . "]";?></th>
				<td> <button class = "ptest-modify-button" onclick = "editQuiz()">Edit Name</button>
				<span class = "ptest-separator">|</span>
				<?php 
						$link_url = add_query_arg( array('edit' => 'results'), $_SERVER["REQUEST_URI"] );?>
				<a title = "Edit how the Results page will look at the end of your quiz" class = "ptest-modify-link" href = "<?php echo $link_url; ?>">Edit Results Page</a></td>
			</tr>
		</table>
		
		<h2>Results<button class = "ptest-add-symbol" onclick = "addNewResult()" title = "Add a new result">+</button></h2>
		<table class = "ptest-quiz-table">
			<tr>
				<th style = "max-width: 5%; width: 5%">#</th>
				<th style = "max-width: 30%; width: 30%">Result Name</th>
				<th style = "max-width: 15%: width: 15%" style = "max-width: 15%: width: 15%">Tags</th>
				<th style = "max-width: 35%: width: 35%" style = "max-width: 35%: width: 35%">Description</th>
				<th style = "max-width: 15%; width: 15%">Options</th>
			</tr>
		<?php 
		$result_counter = 0;
		foreach($results_list as $result){
			$result_counter++;?>
			<tr>
				<td><?php echo $result_counter; ?></td>
				<td><?php echo $result->name; ?></td>
				<td><?php echo $result->tag; ?></td>
				<td><?php echo stripslashes( $result->description ); ?></td>
				<td><button class = "ptest-modify-button" onclick = "editResult(<?php  echo $result->id . ", '" . $result->name . "', '" . $result->tag . "', '" . $result->description . "'"  ?> )">Edit</button>
				<span class = "ptest-separator">|</span>				
				<form onsubmit = "return confirm('Are you sure you want to delete?');" name = "ptest-result-delete" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post"  style = "display: inline">
					<input type = "hidden" name = "ptest_result_delete_hidden" value = "Y">
					<input type = "hidden" name = "ptest_result_id_hidden" value = "<?php echo $result->id ?>">
					<input class = "ptest-delete-submit" type = "submit" value = "Delete">
				</form></td>
				
			</tr>
		<?php } ?>
		</table>
		
		<h2>Questions<button class = "ptest-add-symbol" onclick = "addNewQuestion()" title = "Add a new question">+</button></h2>
		<table class = "ptest-quiz-table">
			<tr>
				<th style = "width: 5%; max-width: 5%">#</th>
				<th style = "width: 30%; max-width: 30%; overflow; hidden;">Question</th>
				<th style = "width: 50%; max-width: 50%">Answers</th>
				<th style = "width: 15%; max-width: 15%">Options</th>
			</tr>
		<?php
		$question_counter = 0;
		foreach($questions_list as $question){
			$question_counter++;?>
			<tr>
				<td><?php echo $question_counter; ?></td>
				<td><?php echo $question->question;?></td>
				<td>
					<table class = "ptest-quiz-answer-table">
						<tr>
							<th style = "width: 5%; max-width:5%">#</th>
							<th style = " width: 40%; max-width: 40%">Answer</th>
							<th style = "width: 40%; max-width: 40%">Tags</th>
							<th style = "width: 10%; max-width: 10%">Value</th>
						</tr>
						<?php
						$click_params = "{$question->id}, \"{$question->question}\"";
						$answers_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_answers WHERE question_id = " . $question->id);
						$answer_counter = 0;
						foreach($answers_list as $answer){
							$answer_counter++;?>
							<tr>
								<td><?php echo $answer_counter;?></td>
								<td style = "max-width: 200px"><?php echo $answer->answer;?></td>
								<td><?php echo $answer->tag;?></td>
								<td><?php echo $answer->value;?></td>
							</tr>
							
						<?php $click_params .= ", [\"{$answer->answer}\", \"{$answer->tag}\", \"{$answer->value}\"]"; } ?>
					</table>
				</td>
				<td><button class = "ptest-modify-button" id="question<?php echo $question->id ?>">Edit</button>
				<span class = "ptest-separator">|</span>
				<form onsubmit = "return confirm('Are you sure you want to delete?');" name = "ptest-question-delete" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post" style = "display: inline">
					<input type = "hidden" name = "ptest_question_delete_hidden" value = "Y">
					<input type = "hidden" name = "ptest_question_id_hidden" value = "<?php echo $question->id ?>">
					<input class = "ptest-delete-submit" type = "submit" value = "Delete">
				</form></td>
				
			</tr>
		<?php 
			echo "<script type='text/javascript'> addClick(\"question" . $question->id . "\", '" . $click_params . "');</script>";
		} ?>
		</table>
		
		
	</div>



	<div class = "ptest-edit-hover" style = "display: none" id = "ptest-hover">
		<div id = "ptest-edit-quiz" style = "display: none">
			<h2 class = "ptest-edit-h2">Edit Quiz Name</h2>
			<div><span class = "ptest-helper">This is the name of the quiz as it will appear on your website.</span></div>
			<br>
			<form name = "ptest-quiz-mod" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
				<input type = "hidden" name = "ptest_quiz_name_hidden" value = "Y">
				<div class = "ptest-form-spacer">Quiz Name:</div> <input type = "text" placeholder = "Quiz Name" class = "ptest-form-input-spacer" id = "ptest_quiz_name_change" name = "ptest_quiz_name_change" value = "<?php echo $quiz->name; ?>" required>
				<input class = "ptest-form-submit" type = "submit" value = "Save">
			</form>
			<br>
		</div>
	</div>
	<div class = "ptest-question-hover" style = "display: none" id = "ptest-question-hover">
		<div id = "ptest-add-result" style = "display: none">
			<h2 class = "ptest-edit-h2" id = "result-header">Add Result</h2>
			<div><span id = "ptest-helper-results" class = "ptest-helper">Add a new Result to your quiz.  The name of the Result is how it will appear at the end of your quiz.<br> Results match with answers by matching tags and counting values. A result can have multiple comma separated tags (ex: tag1, tag2, tag3).</span></div>
			<br>
			<form name = "ptest-result" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
				<input type = "hidden" name = "ptest_result_add_hidden" id = "ptest_result_add_hidden" value = "edit">
				<input type = "hidden" name = "ptest_result_id_hidden" id = "ptest_result_id_hidden">
				<div class = "ptest-form-spacer">Result Name:</div> <input type = "text" placeholder = "Result Name" name = "ptest_result_name" id = "ptest_result_name" class = "ptest-form-input-spacer" required>
				<br>
				<div class = "ptest-form-spacer">Tags:</div> <input type = "text" placeholder = "tag1, tag2" name = "ptest_result_tags" id = "ptest_result_tags" class = "ptest-form-input-spacer" required>
				<br>
				<div class = "ptest-form-spacer">Description:</div> <textarea placeholder = "Description" name = "ptest_result_description" id = "ptest_result_description" class = "ptest-form-input-spacer"></textarea><!--<input type = "text"  >-->
				<br><div style = "display: inline-block; width: 87%"></div><input class = "ptest-form-submit" type = "submit" value = "Save">
			</form>
			<br>
		</div>
	
		<div id = "ptest-add-question" style = "display: none">
			<h2 class = "ptest-edit-h2" id = "ptest-question-header">Add Question</h2>
			<div><span id = "ptest-helper-questions" class = "ptest-helper">Add a new question to your quiz.</div>
			<br>
			<form name = "ptest-ques-add" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method = "post">
				<input type = "hidden" name = "ptest_question_hidden" id = "ptest_question_hidden" value = "edit">
				<input type = "hidden" name = "ptest_question_id_hidden" id = "ptest_question_id_hidden">
				<div class = "ptest-form-spacer">Question:</div> <input type = "text" placeholder = "The Question" name = "ptest_question_question" id = "ptest_question_question" class = "ptest-form-input-spacer" required>
				<br>
				<span style = "font-size: 30px;" class = "ptest-add-symbol" type = "button" onclick = "addNewAnswer()" title = "Add a new answer to this question.">+</span>
				<br>
				<div id = "ptest-answers-form"></div>
				<input class = "ptest-form-submit" type = "submit" value = "Save">
			</form>
		</div>
	</div>
	
	<div class = "ptest-display-hidden-hover-closer" id = "ptest-hidden-hover" onclick = "removeHover()"></div>
</div>
</div>