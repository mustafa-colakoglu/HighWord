<?php
	namespace Controllers\BlogTest;
	use MS\MSController;
	class Tag extends MSController{
		function actionIndex(){
			$data = array();
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
				$Tags = explode(",",$this->url[2]);
				$data["Tags"] = $this->url[2];
			}
			else{
				$Tags = "";
				$data["Tags"] = "";
			}
			$Limit = 2;
			$data["posts"] = $this->model("Post")->GetPosts(array("Tags" => $Tags, "Pagination" => array("Page" => $Page,"Limit" => $Limit)));
			$data["kategoriler"] = $this->model("Category")->GetCategories();
			$data["toplamsayfa"] = count($this->model("Post")->GetPosts(array("Tags" => $Tags)))/$Limit;
			$data["suankisayfa"] = $Page;
			$this->view("BlogTest/Header");
			$this->view("BlogTest/TagSection",$data);
			$this->view("BlogTest/View");
		}
	}
?>