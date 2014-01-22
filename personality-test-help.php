<script type = "text/javascript">
	function addMargin(){
		window.scrollTo(0, window.pageYOffset - 30);
	}
	window.addEventListener('hashchange', addMargin);
</script>

<div class = "wrap">
	<h2>Help</h2>
	Table of Contents:
	<ol>
		<li><a href = "#qi">Quick Introduction</a></li>
		<li><a href = "#create">Creating a Quiz</a></li>
		<li><a href = "#modscreen">Modifying a Quiz</a></li>
		<li><a href = "#addr">Adding Results</a></li>
		<li><a href = "#addq">Adding Questions</a></li>
		<li><a href = "#trp">The Results Page</a></li>
		<li><a href = "#atw">Adding the Quiz to Your Website</a></li>
		<li><a href = "#fi">Further Information</a></li>
	</ol>
	
	<ol class = "ptest-help-ol">
		<li>
			<a name = "qi">Quick Introduction</a>
			<p class = "ptest-help-ol-p">Welcome to Ptest, an easy to use interest and personality test creator. Select <a href = "<?php echo add_query_arg(array('page' => 'Quiz'), admin_url('admin.php'))?>" >Quiz List</a> if you want to get started right away. If not, continue to <a href = "#create">Creating a Quiz</a> to continue with this tutorial</p>
		</li>
		<li>
			<a name = "create">Creating a Quiz</a>
			<p class = "ptest-help-ol-p">Creating a quiz is simple. First, select <a href = "<?php echo add_query_arg(array('page' => 'Quiz'), admin_url('admin.php'))?>" >Quiz List</a> from the dropdown in the admin menu, or click the link. You will be taken to the quiz list screen. <img style = "width: 80%" src = "<?php echo plugins_url( "img/empty-quiz-list.png", __FILE__) ?>"></P>
			<p class = "ptest-help-ol-p">Select the "+" next to the Quiz List to add a new quiz to your database. <img style = "width:80%" src = "<?php echo plugins_url("img/adding-a-quiz.png", __FILE__) ?>"></p>
			<p class = "ptest-help-ol-p">Type in any name you want (you can change it later) and select Save. The quiz will be immediately added to your list of quizzes! To delete it, select delete. To add questions and results or to change its name, select <a href = "#modscreen">Modify</a>. <div><img style = "width:80%" src = "<?php echo plugins_url("img/added-quiz.png", __FILE__) ?>"></div></p>
		</li>
		<li>
			<a name = "modscreen">Modifying a Quiz</a>
			<p class = "ptest-help-ol-p">The Modify screen has all the possible modifications you can make to a quiz. <img style = "width:80%" src = "<?php echo plugins_url("img/mod-screen.png", __FILE__)?>"></p>
			<p class = "ptest-help-ol-p">If you would like to change the quizzes name, select Edit Name. If you would like to learn about Edit Results Page, proceed to <a href = "#trp">The Results Page</a>. If you're continuing in order, scroll down to <a href = "#addr">Adding Results</a> or if you've already figured that out and just need to figure out how to make the questions and results work together, head to <a href = "#addq">Adding Questions</a>.
		</li>
		<li>
			<a name = "addr">Adding Results</a>
			<p class = "ptest-help-ol-p">Select the + next to Results in order to add a result. <img style = "width:80%" src = "<?php echo plugins_url("img/add-a-result.png", __FILE__)?>"></p>
			<p class = "ptest-help-ol-p">There are 3 inputs you need to fill out.
				<ol class = "ptest-help-ol-p">
					<li>Result Name: Result Name is the name of your result. For example, if you had a "Which Star Wars character are you?" personality test and you wanted one of the results to be Darth Vader, you would write Darth Vader as the name of this result.</li>
					<li>Tags: Tags are a unique identifier that determine how the results will match up with the questions. If a tag in a result and a tag in a question match, then the value of the question will be added to that result. The result with the highest point value at the end of the quiz will be the result shown. If this doesn't make sense now, it will be explained more thoroughly in <a href = "#addq">Adding Questions</a>. Tags can be called anything you like, as only the quiz creator will be able to see them. The option to have multiple tags is there, but currently serves no purpose (it does in questions!), it will hopefully be used in a future build.
					</li>
					<li>Description: This is where you want to write what gets displayed under this result. The description will be displayed along with Result Name on completion of the quiz.</li>
				</ol></p>
			<p class = "ptest-help-ol-p">Once you have filled out all the inputs, select Save and the new Result will be added to your Quiz. Normally, you would not want the same result to show up every time, so adding a few more Results is probably a good idea. You can add as many Results as you want. Remember to make all the Tags unique so the point values from questions get added to the correct result. To make changes to any Result, you can select Edit When you have finished adding Results, head over to <a href = "#addq">Adding Questions</a></p>
		</li>
		<li>
			<a name = "addq">Adding Questions</a>
			<p class = "ptest-help-ol-p">Select the + next to Questions in order to add a question to your quiz. <img style = "width:80%" src = "<?php echo plugins_url("img/adding-a-question.png", __FILE__)?>"></p>
			<p class = "ptest-help-ol-p">Questions are the last thing that need to be added to the quiz, there are a few things that need to be filled out per question
				<ol class = "ptest-help-ol-p">
					<li>Question: Question is the Question as it will be displayed on your quiz</li>
					<li>The green + in the Add Question screen adds an answer box below. As many answers as you want can be added. To Delete an answer simply select the red Delete button within an answer box and that Answer will be removed forever.</li>
					<li>The Answer: Each bordered box is its own answer, when actually taking the quiz, the only things that will be shown are the number of the answer and whatever you write in the input box that has the placeholder "The Answer". Tags and Value are for internal use only. There is currently no way to reorder answers except by deleting and re-entering them.</li>
					<li>Tags: Tags are how an answer matches up to its Result. For example, if you had Darth Vader as a result with the tag "darth", and you wanted this answer to reflect on the Darth Vader result, in tags you would write "darth". Answers can also match up to multiple results by simply adding more tags separated by commas. For example, if you also had a Han Solo result with the tag "han", and you wanted this answer to reflect on both, you could write "darth, han" and both Han Solo and Darth Vader would be given points.</li>
					<li>Value: The Value of the answer. When this answer is chosen it will add the point value you've assigned to it to whatever tags you've assigned to it. So if your tags were "darth, han" and you put "4" as the value, then 4 points would be assigned to both Darth Vader and Han Solo. The Result with the most points at the end of the quiz will be the Result shown at the end of the quiz. You can also put negative numbers for values if you would like to detract points from a Result for choosing this answer. </li>
				</ol></p>
			<p class = "ptest-help-ol-p">Once you have filled out all the inputs and finished up adding as many Answers as you want, select Save and the Question will be added to your quiz. Add as many questions as you like to your quiz. To make changes to any Question, you can select Edit question and change whatever you like. <a href = "#trp">The Results Page</a> deals with some HTML, if you do not want to deal with that right now, there is a default Result page already set up and you can head straight to <a href = "#atw">Adding the Quiz to Your Website</a>.</p>
		</li>
		<li>
			<a name = "trp">The Results Page</a>
			<p class = "ptest-help-ol-p">The Results Page deals with some HTML, if you do not know HTML and are fine with how the default Results page displays, skip to <a href = #atw">Adding the Quiz to Your Website</a>. Still here? Then click Edit Results Page up in the Quiz Information box on the Modify page. <img style = "width:80%" src = "<?php echo plugins_url("img/edit-results-page.png", __FILE__)?>"> </p>
			<p class = "ptest-help-ol-p">Each Quiz you make has its own Results Page, and its HTML is displayed here. The box is a giant input where you can write whatever HTML you want and it will show up as your results page after taking the test. There are a few shortcodes.
				<ol class = "ptest-help-ol-p">
					<li>[result]: [result] is the name of your result, so if your winning result's name was Darth Vader, [result] would be replaced by Darth Vader when viewing the Results Page.
					<li>[description]: [description] is the description of your result. Whatever you wrote for the result's description will replace [description] when viewing the Results Page.
				</ol></p>
			<p class = "ptest-help-ol-p"><img style = "width:80%" src = "<?php echo plugins_url("img/editing-results-page.png", __FILE__)?>"></p>
			<p class = "ptest-help-ol-p">When finished select Save Changes and it will Save your changes as the new Results Page. If you want to go back to the default Results page, select Reset. However, be warned that once you confirm Reset, there is no way to return to your changes.</p>
		</li>
		<li>
			<a name = "atw">Adding the Quiz to Your Website</a>
			<p class = "ptest-help-ol-p">Adding the quiz to your website is easy! Either in the Quiz List screen or in the Quiz Information box of the Modify screen there is a table header called Short Code. To add the quiz to your website, simply copy the Short Code and paste it into a Post or a Page. <img style = "width:80%" src = "<?php echo plugins_url("img/add-to-site.png", __FILE__)?>"></p>
			<p class = "ptest-help-ol-p">Congratulations! You've just added your quiz to your website. Feel free to edit or change it at any time, the changes will show up right away. Questions, comments, concerns, suggestions? Head down to <a href = "#fi">Further Information</a>. Enjoy.
		</li>
		<li>
			<a name = "fi">Further Information</a>
			<p class = "ptest-help-ol-p">If you want to make a suggestion or a request for new functionality, or you've found a bug and you'd like it fixed, or you just want someone to talk to, send us an email at admin@trurek.com, we'll do our best to respond! Thanks for using Ptest!</p>
		</li>
</div>