<?php
	namespace Controllers\BlogTest;
	use MS\MSController;
	use MS\Acl;
	class BlogTest extends MSController{
		function __construct(){
			parent::__construct();
			$this->acl = new Acl();
			$this->acl->setAccess(array(
				array(
					"actions" => array("actionIndex"),
					"expression" => $this->model("BlogTest/KullaniciVarmi")->Kontrol(),
					"redirect" => "BlogTest/Install"
				)
			));
		}
		function actionIndex(){
			if(isset($this->url[1])){
				if(is_numeric($this->url[1])){
					$Page = $this->url[1];
				}
				else{
					$Page = 0;
				}
			}
			else{
				$Page = 0;
			}
			$data = array();
			$Limit = 2;
			$data["posts"] = $this->model("Post")->GetPosts(array("Pagination" => array("Page" => $Page,"Limit" => $Limit)));
			$data["kategoriler"] = $this->model("Category")->GetCategories();
			$data["toplamsayfa"] = count($this->model("Post")->GetPosts())/$Limit;
			$data["suankisayfa"] = $Page;
			$this->view("BlogTest/Header");
			$this->view("BlogTest/Section",$data);
			$this->view("Footer");
		}
	}
?>