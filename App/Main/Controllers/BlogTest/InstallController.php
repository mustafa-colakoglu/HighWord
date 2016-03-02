<?php
	namespace Controllers\BlogTest;
	use MS\MSController;
	use MS\Acl;
	use get;
	class Install extends MSController{
		function __construct(){
			parent::__construct();
			$this->acl = new Acl();
			$this->acl->setAccess(array(
				array(
					"actions" => array("actionIndex"),
					"expression" => !$this->model("BlogTest/KullaniciVarmi")->Kontrol(),
					"redirect" => "BlogTest"
				)
			));
		}
		function actionIndex(){
			if($_POST){
				$Kaydet = $this->model("BlogTest/IlkKullaniciKayit")->Kaydet();
				if($Kaydet){
					header("Location:".get::site()."/BlogTest");
				}
				else{
					
				}
			}
			$this->view("BlogTest/YeniKullaniciKayitForm");
		}
	}
?>