<?php
	namespace Models;
	use MS\MSModel;
	use User;
	class PostModel extends MSModel{
		function __construct(){
			parent::__construct();
		}
		function NewPost($PostUserId = 1, $PostTitle = "", $Post = "", $PostDate = ""){
			$PostTime = time();
			if($PostDate == ""){
				$PostDate = date("d.m.Y");
			}
			$this->insert("high_posts",false,"'','$PostUserId','$PostTitle','$Post','','$PostDate','$PostTime'");
		}
		function UpdatePost(){
			
		}
	}
?>