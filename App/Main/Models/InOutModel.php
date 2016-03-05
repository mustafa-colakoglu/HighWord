<?php
	namespace Models;
	use MS\MSModel;
	use MS\Session;
	class InOutModel extends MSModel{
		function isLogin(){
			$Login = Session::get("HighLogin");
			return $Login;
		}
		function login($Username = false, $Password = false){
			if($Username and $Password){
				$Control = $this->select("high_users","UserName='$Username' and Password='$Password'");
				if(count($Control)>0){
					Session::set("HighLogin",true);
					return true;
				}
				else{
					return false;
				}
			}
		}
		function logout(){
			Session::set("HighLogin",false);
		}
	}
?>