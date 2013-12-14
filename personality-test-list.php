<?php  	

	/**********LIST ALL EDITABLE QUIZZES************/
	global $wpdb;
	$quiz_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ptest_quizzes");
	?>
	<table>
			<tr>
				<th>#</th>
				<th>Quiz Name</th>
				<th>Short Code</th>
				<td>Options</th>
			</tr>
	<?php foreach($quiz_list as $quiz){
		?><tr>
			<td> <?php echo $quiz->id; ?></td>
			<td> <?php echo $quiz->name; ?></td>
			<td> <?php echo "[ptest id=" . $quiz->id . "]"; ?></td>
			<td> 
				<?php 
				$link_url = add_query_arg( array('edit' => '1', 'id' => $quiz->id), $_SERVER["REQUEST_URI"] );?>	
				<a href = "<?php echo $link_url; ?>"> Check </a></td>
		</tr>
	<?php } ?>
	</table>
	<?php
	
?>