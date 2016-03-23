<?php
	namespace Controllers\BlogTest;
	use MS\MSController;
	use MS\Acl;
	use Journal;
	use Friend;
	class Gundem extends MSController{
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
			$Journal = new Journal();
			$data["Tags"] = $Journal->GetTags();
			$this->view("BlogTest/Header");
			$this->view("BlogTest/Journal",$data);
			$this->view("BlogTest/Footer");
		}
	}
?>