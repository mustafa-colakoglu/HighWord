<?php
	namespace Controllers\BlogTest;
	use MS\MSController;
	use MS\Acl;
	class PostDetail extends MSController{
		function __construct(){
			parent::__construct();
			$this->acl = new Acl(array(
				array(
					"actions" => array("actionIndex"),
					"expression" => $this->UrlControl(),
				)
			));
		}
		function actionIndex(){
			$this->view("BlogTest/Header");
			$data["Post"] = $this->model("Post")->GetPost($this->url[2]);
			$data["PostObject"] = $this->model("Post");
			$this->view("BlogTest/PostDetailSection",$data);
			$this->view("BlogTest/Footer");
		}
		function UrlControl(){
			if(isset($this->url[2])){
				if(intval($this->url[2]) == 0){
					return false;
				}
				return true;
			}
			return false;
		}
	}
?>