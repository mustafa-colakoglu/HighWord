<?php
	namespace Models\BlogTest;
	use MS\MSModel;
	class IlkKullaniciKayitModel extends MSModel{
		function Kaydet(){
			$kadi = $_POST["kadi"];
			$sifre = $_POST["sifre"];
			$email = $_POST["email"];
			$User = $this->model("User");
			$Kaydet = $User->NewUser($kadi, $sifre, $email);
			if($Kaydet){
				$User->UpdateUser($Kaydet,"Adminmi",1);
				$User->ActivateUser($Kaydet);
				return true;
			}
			else{
				echo $User->ErrorDetail;
			}
		}
	}
?>