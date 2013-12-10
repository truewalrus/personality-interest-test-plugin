<?php

/*Add an empty quiz to the database
Requires: $quizName: name of the quiz*/
function ptest_insert_quiz($name){
	
	global $wpdb;
	
	$data = array('name'=>$name);
	
	$wpdb->insert($wpdb->prefix . "ptest_quizzes", $data);
	
	return $wpdb->insert_id;
}

/*Add results to a quiz
Requires: $result: array containing; name: name of result, tags: list of tags (csv string), quiz_id: id of quiz for these results ?*/
function ptest_insert_result($result){
	
	global $wpdb;
	
	$data = array('name'=>$result["name"], 'tags' => $result["tags"], 'quiz_id' => $result["quiz_id"]);
	
	$wpdb->insert($wpdb->prefix . "ptest_results", $data);
	
	return $wpdb->insert_id;

}


function ptest_insert_question($question){
	//return "you made it here";

	global $wpdb;
	
	$data = array('question'=>$question);
	
	$wpdb->insert($wpdb->prefix . "ptest_questions", $data);
	
	return $wpdb->insert_id;
}

function ptest_insert_answer($qId, $answers){

	global $wpdb;
	
	foreach ($answers as $answer){
		$data = array('question_id' => $qId, 'answer' => $answer);
		$wpdb->insert($wpdb->prefix . 'ptest_answers', $data);
		echo $wpdb->insert_id;
	}
}
?>
