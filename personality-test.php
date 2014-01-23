<?php
/* 
	Plugin Name: Personality Test
	Description: Plugin for creating easily modifiable Personality, Interest, or Which Character are You? tests and quizzes.
	Author: J. Levy and B. Bower
	Version: 1.0 
	Author URI: http://www.trurek.com
	*/  

	
	include('personality-test-db-functions.php');
	
	function ptest_admin() {  
        include('personality-test-main.php');  
    } 

	function ptest_quiz_main(){
		include('personality-test-quiz-main.php');
	}
	
	function ptest_help(){
		include('personality-test-help.php');
	}
      
    function ptest_admin_actions() {  
        add_menu_page("Personality Test", "Ptest Dashboard", 'manage_options', "Personality_Test", "ptest_admin");
    }  
    add_action('admin_menu', 'ptest_admin_actions');
	
	function ptest_quiz_main_actions() {
		add_submenu_page("Personality_Test", "Quiz List", "Quiz List", 'manage_options', "Quiz", "ptest_quiz_main");
		add_submenu_page("Personality_Test", "Help", "Help", 'manage_options', "Help", "ptest_help");
	}
	add_action('admin_menu', 'ptest_quiz_main_actions');
	
	function ptest_add_stylesheet(){
		wp_register_style('personality-test-style', plugins_url('personality-test/css/personality-test-style.css'));
		wp_enqueue_style('personality-test-style');
	}
	add_action('admin_enqueue_scripts', 'ptest_add_stylesheet');
	
	function ptest_add_frontend_stylesheet(){
		wp_register_style('personality-test-frontend-style', plugins_url('personality-test/css/personality-test-frontend-style.css'));
		wp_enqueue_style('personality-test-frontend-style');
	}
	add_action('wp_enqueue_scripts', 'ptest_add_frontend_stylesheet');
	
	function ptest_admin_scripts(){
		if (isset($_GET['page']) && $_GET['page'] == 'Quiz'){
			wp_enqueue_media();
			wp_register_script('personality-test-admin.js', plugins_url().'/personality-test/personality-test-admin.js', array('jquery'));
			wp_enqueue_script('personality-test-admin.js');
		}
	}
	add_action('admin_enqueue_scripts', 'ptest_admin_scripts');
	
	function ptest_database_init(){

		global $wpdb;

		$quiz_table = $wpdb->prefix . "ptest_quizzes";
		$results_table = $wpdb->prefix . "ptest_results";
		$questions_table = $wpdb->prefix . "ptest_questions";
		$answers_table = $wpdb->prefix . "ptest_answers";
		
		$sql = "CREATE TABLE $quiz_table (
                                id int NOT NULL AUTO_INCREMENT,
                                name tinytext,
								results_page text,
                                PRIMARY KEY id (id)
                                );";
					   
		$results_sql = "CREATE TABLE $results_table (
						id int NOT NULL AUTO_INCREMENT,
						name tinytext,
						quiz_id int,
						tag tinytext,
						description text,
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