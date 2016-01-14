<?php
	namespace Models;
	use MS\MSModel;
	class PostModel extends MSModel{
		function __construct(){
			parent::__construct();
		}
		function NewPost($PostUserId = 1, $PostTitle = "", $Post = "", $PostImage = "", $PostDate = "", $PostTime = ""){
			$this->insert("high_posts",false,"'','$PostUserId','$PostTitle','$Post','$PostImage','$PostDate','$PostTime'");
		}
	}
?>