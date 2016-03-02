<?php
	namespace Models\BlogTest;
	use MS\MSModel;
	class KullaniciVarmiModel extends MSModel{
		function Kontrol(){
			$KullaniciVarmi = count($this->select("high_users","","","LIMIT 1"));
			if($KullaniciVarmi > 0){
				return true;
			}
			return false;
		}
	}
?>