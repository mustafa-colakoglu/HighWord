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
		function UpdatePost($PostId = false,$Updates = false){
			if($PostId){
				$PostId = $this->Uselib->Clean($PostId);
				if($PostId != ""){
					$UpdatesNew = "";
					$UpdatesAdd = array();
					foreach($Updates as $Sub => $Value){
						if($Sub == "PostUserId" || $Sub == "PostTitle" || $Sub == "Post" || $Sub == "PostDate" || $Sub == "PostTime"){
							$UpdatesNew.=$Sub."='".$Value."',";
						}
						else{
							$UpdatesAdd[$Sub] = $Value;
						}
					}
					$UpdatesNew = trim($UpdatesNew,",");
					$this->update("high_posts",$UpdatesNew,"PostId='$PostId'");
					foreach($UpdatesAdd as $Sub => $Value){
						
					}
				}
			}
		}
	}
?>