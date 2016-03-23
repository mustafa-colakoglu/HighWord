<?php
	namespace Controllers\BlogTest;
	use MS\MSController;
	class Category extends MSController{
		function actionIndex(){
			if(isset($this->url[3])){
				if(is_numeric($this->url[3])){
					$Page = $this->url[3];
				}
				else{
					$Page = 0;
				}
			}
			else{
				$Page = 0;
			}
			if(isset($this->url[2])){
				if(intval($this->url[2] != 0)){
					$CatId = $this->url[2];
					$data["CatId"] = $CatId;
				}
				else{
					header("Location:".$this->site."/BlogTest/Main");
				}
			}
			else{
				header("Location:".$this->site."/BlogTest/Main");
			}
			$Limit = 5;
			$data["posts"] = $this->model("Post")->GetPosts(array("CategoryId" => array($CatId), "Pagination" => array("Page" => $Page,"Limit" => $Limit)));
			$data["kategoriler"] = $this->model("Category")->GetCategories();
			$data["toplamsayfa"] = count($this->model("Post")->GetPosts(array("CategoryId" => array($CatId))))/$Limit;
			$data["suankisayfa"] = $Page;
			$this->view("BlogTest/Header");
			$this->view("BlogTest/CatSection",$data);
			$this->view("BlogTest/Footer");
		}
	}
?>