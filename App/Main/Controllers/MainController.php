<?php
	namespace Controllers;
	use MS\MSController;
	use get;
	class Main extends MSController{
		function __construct(){
			parent::__construct();
		}
		function actionIndex(){
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8"/>
				<title>HighWord</title>
			</head>
			<body>
				<ul>
					<li><h3>Tests</h3></li>
					<li><a target="_blank" href="<?php echo get::site(); ?>/BlogTest/">Blog Test</a></li>
				</ul>
			</body>
		</html>
		<?php
		}
	}
?>