<?php

///////////////////////////////////////////////////////////////////INSERTS///////////////////////////////////////////////////////////////
/*
ptest_insert_quiz($name) - create a new empty quiz
ptest_insert_result($quiz_id, $result) - add a result to a quiz
ptest_insert_question($quiz_id, $question) - add a question to a quiz
ptest_insert_answer($question_id, $answers) - add a list of answers to a question
*/

/*Add an empty quiz to the database
Requires: $quizName: name of the quiz*/
function ptest_insert_quiz($name){
	
	global $wpdb;
	
	$default_results_page = "<h2>Your result is [result]!</h2>\n<p>[description]</p>";
	
	$data = array('name'=>$name, 'results_page'=>$default_results_page);
	
	$wpdb->insert($wpdb->prefix . "ptest_quizzes", $data);
	
	return $wpdb->insert_id;
}

/*Add a result to a quiz
Requires: $quiz_id: id of quiz to add to, $result: array containing; name: name of result, tags: list of tags (csv string)*/
function ptest_insert_result($quiz_id, $result){
	
	global $wpdb;
	
	$data = array('name'=>$result["name"], 'tag'=>$result["tags"], 'description'=>$result["description"], 'quiz_id'=>$quiz_id);
	
	$wpdb->insert($wpdb->prefix . "ptest_results", $data);
	
	return $wpdb->insert_id;

}

/*Add a question to a quiz
Requires: $question: the question, $quiz_id: quiz to add the question to*/
function ptest_insert_question($quiz_id, $question){

	global $wpdb;
	
	$data = array('question'=>$question, 'quiz_id'=>$quiz_id);
	
	$wpdb->insert($wpdb->prefix . "ptest_questions", $data);
	
	return $wpdb->insert_id;
}


/*Add an array of answers to a question
Requires: $question_id: id of the question to add to,
$answers: list of answers. answers are arrays containing; answer: the text for the answer, value: value of the answer, default 0, tags: list of tags (csv string)*/
function ptest_insert_answers($question_id, $answers){

	global $wpdb;
	
	foreach ($answers as $answer){
		//Give answer a value if it's null
		if( $answer["value"] === null)
		{
			$answer["value"] = 0;
		}
		$data = array('question_id'=>$question_id, 'answer'=>$answer["answer"], 'value'=>$answer["value"], 'tag'=>$answer["tags"]);
		$wpdb->insert($wpdb->prefix . 'ptest_answers', $data);
	}
}


///////////////////////////////////////////////////////////////////DELETES///////////////////////////////////////////////////////////////
/*
ptest_delete_quiz($quiz_id) - delete a quiz
ptest_delete_result($result_id) - delete a result
ptest_delete_question($question_id) - delete a question and its answers
ptest_delete_answer($answer_id) - delete an answer from a question
*/


/*Delete a quiz from the database
Requires: $quiz_id: id of the quiz*/
function ptest_delete_quiz($quiz_id){

	global $wpdb;
	
	//delete the quiz
	$wpdb->delete($wpdb->prefix . "ptest_quizzes", array( 'id' => $quiz_id));
	
	//delete the results from the quiz
	$wpdb->delete($wpdb->prefix . "ptest_results", array( 'quiz_id' => $quiz_id));
	
	//get a list of all the question ids in the quiz in order to obtain question ids to delete answers
	$id_list = $wpdb->get_results("SELECT id FROM " . $wpdb->prefix . "ptest_questions" . " WHERE quiz_id =" . $quiz_id );
	foreach ($id_list as $id){
		//delete the answers of that question
		echo $id->id;
		$wpdb->delete($wpdb->prefix . "ptest_answers", array('question_id' => $id->id));
	}
	//delete the questions from the quiz
	$wpdb->delete($wpdb->prefix . "ptest_questions", array('quiz_id' => $quiz_id));
	
}

/*Delete a result from the database
Requires: $result_id: id of result to delete*/
function ptest_delete_result($result_id){

	global $wpdb;
	
	$wpdb->delete($wpdb->prefix . "ptest_results", array('id' => $result_id));
}

/*Delete a question from the database
Requires: $question_id: id of question to delete*/
function ptest_delete_question($question_id){

	global $wpdb;
	
	//delete the answers of the question
	$wpdb->delete($wpdb->prefix . "ptest_answers", array('question_id' => $question_id));
	//delete the question
	$wpdb->delete($wpdb->prefix . "ptest_questions", array('id' => $question_id));
}

/*Delete an answer from the database
Requires: $answer_id: id of question to delete*/
function ptest_delete_answer($answer_id){
	
	global $wpdb;
	
	$wpdb->delete($wpdb->prefix . "ptest_answers", array('id' => $answer_id));
}

///////////////////////////////////////////////////////////////////Updates///////////////////////////////////////////////////////////////
/*
ptest_update_quiz($quiz_id, $name) - change the name of a quiz
ptest_update_result($result_id, $updated_result) - change the data of a result
ptest_update_question($question_id, $question) - change a question
ptest_update_answers($question_id, $answers) - change the answers to a question
*/

/*Change the name of a quiz
Requires: $quiz_id: id of the quiz to update, $name: the new name of the quiz*/
function ptest_update_quiz($quiz_id, $name){

	global $wpdb;
	
	$wpdb->update($wpdb->prefix . "ptest_quizzes", array('name' => $name), array('id' => $quiz_id));
}

/*Change the info in a result
Requires: $result_id: id of the result to update, $updated_result: array containing; name: name of result, tags: list of tags (csv string)*/
function ptest_update_result($result_id, $result){
	
	global $wpdb;
	
	$data = array('name'=>$result["name"], 'tag'=>$result["tags"], 'description'=>$result["description"]);
	
	$wpdb->update($wpdb->prefix . "ptest_results", $data, array('id' => $result_id));
}

/*Change the question to a new question
Requires: $question_id: id of question to change, $question: the new question*/
function ptest_update_question($question_id, $question){
	
	global $wpdb;
	
	$data = array('question'=>$question);
	
	$wpdb->update($wpdb->prefix . "ptest_questions", array('question'=>$question), array('id'=>$question_id));
}

/*Change the answers to a question
Requires: $queestion_id: id of question with answers to change, 
$answers list of answers. answers are arrays containing; answer: the text for the answer, value: value of the answer, default 0, tags: list of tags (csv string)*/
function ptest_update_answers($question_id, $answers){

	global $wpdb;
	$wpdb->delete($wpdb->prefix . "ptest_answers", array('question_id' => $question_id));
	
	foreach ($answers as $answer){
		//Give answer a value if it's null
		if( $answer["value"] === null)
		{
			$answer["value"] = 0;
		}
		$data = array('question_id'=>$question_id, 'answer'=>$answer["answer"], 'value'=>$answer["value"], 'tag'=>$answer["tags"]);
		$wpdb->insert($wpdb->prefix . 'ptest_answers', $data);		
	}
}
?>
