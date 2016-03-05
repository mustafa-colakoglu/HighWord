<?php
	namespace Models\BlogTest\Admin;
	use MS\MSModel;
	class KategoriModel extends MSModel{
		function KategoriIslemleri(){
			if(isset($_POST["yeni"])){
				$Yeni = $this->Uselib->formDataFix($_POST["yeni"]);
				if(isset($_POST["alt"])){
					$Alt = $_POST["alt"];
					if(!is_numeric($Alt)){
						$Alt = 0;
					}
					if(!empty($Yeni)){
						$this->model("Category")->NewCategory($Yeni, $Alt);
					}
				}
			}
			if(isset($_POST["sil"])){
				$Sil = $_POST["sil"];
				if(is_numeric($Sil)){
					$this->model("Category")->DeleteCategory($Sil);
				}
			}
		}
		function Kategoriler(){
			$data["Kategoriler"] = $this->model("Category")->GetCategories();
			return $data;
		}
	}
?>