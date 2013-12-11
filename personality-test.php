<?php
/* 
	Plugin Name: Personality Test
	Description: Plugin for creating a Personality Test based on interest in subjects
	Author: J. Levy and B. Bower
	Version: 1.0 
	Author URI: http://www.trurek.com
	*/  

	
	include('personality-test-db-functions.php');
	
	function ptest_admin() {  
        include('personality-test-main.php');  
    }  
      
    function ptest_admin_actions() {  
        add_menu_page("Personality Test", "Personality Test", 'manage_options', "Personality_Test", "ptest_admin");
    }  
    add_action('admin_menu', 'ptest_admin_actions');
	
	function ptest_database_init(){

		global $wpdb;

		$quiz_table = $wpdb->prefix . "ptest_quizzes";
		$results_table = $wpdb->prefix . "ptest_results";
		$questions_table = $wpdb->prefix . "ptest_questions";
		$answers_table = $wpdb->prefix . "ptest_answers";
		
		$sql = "CREATE TABLE $quiz_table (
                                id int NOT NULL AUTO_INCREMENT,
                                name tinytext,
                                PRIMARY KEY id (id)
                                );";
					   
		$results_sql = "CREATE TABLE $results_table (
						id int NOT NULL AUTO_INCREMENT,
						name tinytext,
						quiz_id int,
						tag tinytext,
						PRIMARY KEY id (id)
						);";
					   
		$questions_sql = "CREATE TABLE $questions_table (
						id int NOT NULL AUTO_INCREMENT,
						question text,
						position int,
						quiz_id int,
						PRIMARY KEY id (id)
						);";
					   
		$answers_sql = "CREATE TABLE $answers_table (
						id int NOT NULL AUTO_INCREMENT,
						answer text,
						tag tinytext,
						value int,
						question_id int,
						PRIMARY KEY id (id)
						);";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);
		dbDelta($results_sql);
		dbDelta($questions_sql);
		dbDelta($answers_sql);
		
	}
	
	function ptest_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'id' => '0',
			'submit' => ''
			), $atts ) );
	
		$_POST['ptest_id'] = $id;
		$_POST['ptest_submit'] = $submit;
	
		include( 'personality-test-frontend.php' );
	}
	
	register_activation_hook( __FILE__, 'ptest_database_init');
	add_shortcode( 'ptest', 'ptest_shortcode' );

?>