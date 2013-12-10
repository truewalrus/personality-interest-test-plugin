<?php

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
