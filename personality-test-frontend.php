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

	<h1>RESULTS</h1>
	
	<?php $answers = $_POST['ptest_answer'];
		$answer_count = count($answers);
		for( $i = 0; $i < $answer_count; $i++ ) {
			echo "<br>" . $answers[$i];
		}
	?>

<?php } ?>