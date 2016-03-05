<?php
	namespace Controllers\BlogTest\Admin;
	use MS\MSController;
	use MS\Acl;
	use get;
	class Admin extends MSController{
		function __construct(){
			parent::__construct();
			$this->acl = new Acl();
			$this->acl->setAccess(array(
				array(
					"actions" => array(
						"actionIndex",
						"logout",
						"Kategori",
						"Yazilar"
					),
					"expression" => $this->isLogin(),
					"redirect" => "BlogTest/Admin/Giris"
				),
				array(
					"actions" => array("Giris"),
					"expression" => !$this->isLogin(),
					"redirect" => "BlogTest/Admin"
				)
			));
		}
		function before(){
			$this->view("BlogTest/Header");
		}
		function actionIndex(){
			$this->view("BlogTest/Admin/Section");
		}
		function Giris(){
			if($_POST){
				$kadi = $_POST["kadi"];
				$sifre = $_POST["sifre"];
				$Gir = $this->model("InOut")->login($kadi, $sifre);
				if($Gir){
					header("Location:".$this->site."/BlogTest/Admin");
				}
				else{}
			}
			$this->view("BlogTest/GirisForm");
		}
		function logout(){
			$this->model("InOut")->logout();
			header("Location:".$this->site."/BlogTest");
		}
		function isLogin(){
			return $this->model("InOut")->isLogin();
		}
		function Kategori(){
			if($_POST){
				$this->model("BlogTest/Admin/Kategori")->KategoriIslemleri();
			}
			$data = $this->model("BlogTest/Admin/Kategori")->Kategoriler();
			$this->view("BlogTest/Admin/KategoriIslemleri",$data);
		}
		function Yazilar(){
			$data = $this->model("BlogTest/Admin/Kategoriler");
		}
		function after(){
			$this->view("BlogTest/Footer");
		}
	}
?>