<?php
	namespace Controllers\BlogTest;
	use MS\MSController;
	class BlogTest extends MSController{
		function actionIndex(){
			echo "BlogTest <br/>";
			$u = $this->model("User")->checkUserByUserName("mustafa");
			if($u){
				echo "bu user var kayit yapilamadi";
			}
			else{
				echo "bu user yok yeni kayıt yapılıyor";
				$this->model("User")->NewUser("mustafa","mustafa","musto_220@windowslive.com");
			}
		}
	}
?>