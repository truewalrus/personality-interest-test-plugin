<?php 
	global $wpdb;
	$url = parse_url($_SERVER["REQUEST_URI"]);
	wp_parse_str($url["query"], $parsed_url);
	$results_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_results WHERE quiz_id = " . $parsed_url['id']);
	$questions_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_questions WHERE quiz_id = " . $parsed_url['id']);
?>

<h2> Results </h2>
<table>
	<tr>
		<th>#</th>
		<th>Result Name</th>
		<th>Tags</th>
	</tr>
<?php 
foreach($results_list as $result){?>
	<tr>
		<td> <?php echo $result->id; ?></td>
		<td> <?php echo $result->name; ?></td>
		<td> <?php echo $result->tag; ?></td>
	</tr>
<?php } ?>
</table>

<h2> Questions </h2>

<?php $count = 0;
foreach($questions_list as $question) {
	 $count++;
	 echo $count . ". " . $question->question;
	 echo "</br>";
	 $answers_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_answers WHERE question_id = " . $question->id);
	 $ans_count = 0;
	 foreach($answers_list as $answer){
	 	$ans_count++;
		echo "     " . $ans_count . ". " .$answer->answer;
		echo "</br>";
	 }
} ?>