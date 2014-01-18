<?php

	global $wpdb;
	
?>
<?php 
	// If the quiz was not submitted, then load the questions for display.
	if( !$_POST['ptest_results'] ) { 
		$questions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ptest_questions WHERE quiz_id = {$_POST['ptest_id']}");
?>

	<form name="ptest_quiz" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">	
		<?php 
		$count = 0;	
		// For each question in the quiz...
		foreach( $questions as $question ) {
			// Display the question text. ?>	
			<h2><?php echo $question->question ?></h2>
			<?php
				// Retrieve the answers for the question.
				$answers = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ptest_answers WHERE question_id = {$question->id}");
			?>
			<p>
				<ul style="list-style: none;" class="answers">
					<?php
						// For each answer in this question...
						foreach( $answers as $answer ) { 
							// Display the answer as a radio button. ?>
							<li><input type="radio" name="ptest_answer[<?php echo $count ?>]" value="<?php echo $answer->id ?>"> <?php echo $answer->answer ?></li>
					<?php } ?>
				</ul>
			</p>
		<?php 
		// Increase the question total (used for form element indexing)
		$count++;
		} ?>
		<input type="hidden" name="ptest_results" value="true">
		<input type="submit" <?php if( $_POST['ptest_submit'] ) { echo "value=\"{$_POST['ptest_submit']}\""; } ?>>
	</form>
	
<?php 
	// Or, if the quiz was answered and submitted...
	} else {
		$answers = $_POST['ptest_answer'];
		
		// Construct the SQL query for the answers chosen based on the answer ids from the POST data.
		$answer_sql = "SELECT * FROM {$wpdb->prefix}ptest_answers WHERE id IN (";
		
		$answer_count = count($answers);
		$started = false;
		
		// Loop through the answer ids in the POST data, and add it to the SQL query.
		$answer_keys = array_keys( $answers );
		for( $i = 0; $i < $answer_count; $i++ ) {
			if( $i > 0 ) {
				$answer_sql .= ", ";
			}
			$answer_sql .= $answers[$answer_keys[$i]];
		}
		$answer_sql .= ")";
		
		// Retrieve all of the relevant answers from the database
		$answer_results = $wpdb->get_results($answer_sql);
		
		$results = array( );
		
		// Loop through all of the answers and create tag totals
		foreach( $answer_results as $answer ) {
			$tags = array ( );
			
			// If the answer has associated tags, parse them into an array.
			if( !empty( $answer->tag ) ) {
				$tags = explode(',', $answer->tag);	
			}
			
			// Loop through the created tags array
			$tag_count = count($tags);
			for( $i = 0; $i < $tag_count; $i++ ) {
				if( array_key_exists( $tags[$i], $results ) ) {
					// If the tag already exists in the results array (a previous answer has added to it), add the current answer's value to the current tag's value.
					$results[$tags[$i]] += intval($answer->value);
				} else {
					// If the tag does not exist in the results array, append the tag with an initial value equal to the current answer's value.
					$results += array( $tags[$i] => intval($answer->value) );
				}
			}
		}
		
		// Grab the quiz result categories from the database.
		$result_db = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ptest_results WHERE quiz_id = {$_POST['ptest_id']}");
		$total = array( array ( ), array ( ) );
		
		$highest_total = -1;
		$highest_result = -1;
		
		// For each of the results for the quiz...
		foreach( $result_db as $result ) {
			// Add it's title to the final results array
			array_push( $total[0], $result->name );
			$tags = array ( );
			
			// If it has associated tags, parse them into an array.
			if( !empty( $result->tag ) ) {
				$tags = explode(',', $result->tag);
			}
			
			// Result total begins at 0.
			$result_total = 0;
			
			// For each tag associated with the result
			foreach( $tags as $tag ) {
				if( array_key_exists( $tag, $results ) ) {
					// If the tag exists in the previously created array of tags and totals...
					// ...add that tag's total to the current result's total.
					$result_total += $results[$tag];
				}
			}
			
			// Push the final result total to the final results array
			array_push( $total[1], $result_total);
			
			if ($result_total > $highest_total) {
				$highest_total = $result_total;
				$highest_result = count( $total[0] ) - 1;
			}
		}
		
		$result_keys = array_keys( $results );
		$key_count = count($total[0]);
		/*
		for( $i = 0; $i < $key_count; $i++ ) {
			echo "<span onClick=\"clicked(" . $i . ")\">" . $total[0][$i] . ": " . $total[1][$i] . "</span><br>";
		}
		*/
		
		$quiz = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ptest_quizzes WHERE id = {$_POST['ptest_id']}");
		$results_page = $quiz[0]->results_page;
		
		$tok = strtok($results_page, '[');
		$final_result_page = '';
		
		
		while( $tok !== false ) {
			$final_result_page .= $tok;
			
			$tag = strtok(']');
			
			if ($tag === "result" && $highest_result >= 0) {
				$final_result_page .= $total[0][$highest_result];
			}
			else {
				$final_result_page .= $tag;
			}
			
			$tok = strtok('[');
		}
		
		echo $final_result_page;
	?>
<?php } ?>