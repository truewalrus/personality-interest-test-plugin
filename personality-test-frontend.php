<?php

	global $wpdb;
	
?>
<?php if( !$_POST['ptest_results'] ) { 
	$questions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ptest_questions WHERE quiz_id = {$_POST['ptest_id']}");
?>

	<form name="ptest_quiz" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">	
		<?php 
		$count = 0;	
		foreach( $questions as $question ) { ?>	
			<h2><?php echo $question->question ?></h2>
			<?php
				$answers = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ptest_answers WHERE question_id = {$question->id}");
			?>
			<p>
				<ul style="list-style: none;" class="answers">
					<?php foreach( $answers as $answer ) { ?>
						<li><input type="radio" name="ptest_answer[<?php echo $count ?>]" value="<?php echo $answer->id ?>"> <?php echo $answer->answer ?></li>
					<?php } ?>
				</ul>
			</p>
		<?php 
		$count++;
		} ?>
		<input type="hidden" name="ptest_results" value="true">
		<input type="submit" <?php if( $_POST['ptest_submit'] ) { echo "value=\"{$_POST['ptest_submit']}\""; } ?>>
	</form>
	
<?php } else { ?>
	
	<script type="text/javascript">
		function clicked(value) {
			alert(value);
		}
	</script>
	
	<?php $answers = $_POST['ptest_answer'];
		$answer_sql = "SELECT * FROM {$wpdb->prefix}ptest_answers WHERE id IN (";
		
		$answer_count = count($answers);
		$started = false;
		
		$answer_keys = array_keys( $answers );
		for( $i = 0; $i < $answer_count; $i++ ) {
			if( $i > 0 ) {
				$answer_sql .= ", ";
			}
			$answer_sql .= $answers[$answer_keys[$i]];
		}
		$answer_sql .= ")";
		
		$answer_results = $wpdb->get_results($answer_sql);
		
		$results = array( );
		
		foreach( $answer_results as $answer ) {
			$tags = array ( );
			
			if( !empty( $answer->tag ) ) {
				$tags = explode(',', $answer->tag);	
			}
			
			$tag_count = count($tags);
			for( $i = 0; $i < $tag_count; $i++ ) {
				if( array_key_exists( $tags[$i], $results ) ) {
					$results[$tags[$i]] += intval($answer->value);
				} else {
					$results += array( $tags[$i] => intval($answer->value) );
				}
			}
		}
		
		$result_db = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ptest_results WHERE quiz_id = {$_POST['ptest_id']}");
		$total = array( array ( ), array ( ) );
		
		foreach( $result_db as $result ) {
			array_push( $total[0], $result->name );
			$tags = array ( );
			
			if( !empty( $result->tag ) ) {
				$tags = explode(',', $result->tag);
			}
			
			$result_total = 0;
			
			foreach( $tags as $tag ) {
				if( array_key_exists( $tag, $results ) ) {
					$result_total += $results[$tag];
				}
			}
			
			array_push( $total[1], $result_total);
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
		
		//echo $results_page;
		
		$tok = strtok($results_page, '[');
		$final_result_page = '';
		
		
		while( $tok !== false ) {
			$final_result_page .= $tok;
			
			$tag = strtok(']');
			
			if ($tag === "result") {
				$final_result_page .= $total[0][0];
			}
			else {
				$final_result_page .= $tag;
			}
			
			$tok = strtok('[');
		}
		
		echo $final_result_page;
	?>
<?php } ?>