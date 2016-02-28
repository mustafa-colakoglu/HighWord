<?php
	namespace Controllers;
	use MS\MSController;
	class Main extends MSController{
		function __construct(){
			parent::__construct();
		}
		function actionIndex(){
			echo "HighWord is started";
		}
		function GetPostTest(){
			// URL : Main/GetPostTest
			//$Ekle = $this->model("Post")->NewPost(1,"deneme baslik","test post",date("d.m.y-H.i.S"));
			$veriler = $this->model("Post")->GetPosts();
			foreach($veriler as $veri){
			?>
				<h1><?php echo $veri["PostId"]." : ".$veri["PostTitle"]; ?> : <?php echo $veri["PostDate"] ?></h1>
				<p><?php echo $veri["Post"]; ?></p>
			<?php
			}
		}
	}
?>