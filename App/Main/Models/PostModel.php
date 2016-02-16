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
						$this->RegisterPostInfo($PostId,$Sub,$Value);
					}
				}
			}
		}
		function RegisterPostInfo($PostId = false,$SubScript = false,$Value = ""){
			if($PostId and $SubScript){
				$PostId = $this->Uselib->Clean($PostId);
				if($PostId){
					$Control = $this->select("high_post_info","PostId='$PostId' and SubScript='$SubScript'");
					if(count($Control)<0){
						$this->insert("high_post_info",false,"'','$PostId','$SubScript','$Value'");
					}
					else{
						$this->update("high_post_info","Value='$Value'","PostId='$PostId' and SubScript='$SubScript'");
					}
				}
			}
		}
		function AddPostTag($PostId = false, $Tags = false){
			if($PostId and $Tags){
				$PostId = $this->Uselib->Clean($PostId);
				if($PostId){
					if(is_string($Tags)){
						$Tags = $this->Uselib->formDataFix($Tags);
						$this->insert("high_post_tags",false,"'','$PostId','$Tags'");
					}
					else if(is_array($Tags)){
						for($i=0;$i<count($Tags);$i++){
							$Tag = $this->Uselib->Clean($Tags[$i]);
							$this->insert("high_post_tags",false,"'','$PostId','$Tag'");
						}
					}
					else{
						return false;
					}
				}
			}
		}
		function UploadPostImage($PostId = false,$Files = false,$ImageType = 0,SetImage $Settings){
			if($PostId and $Files){
				$PostId = $this->Uselib->Clean($PostId);
				if($PostId){
					if(isset($_FILES[$Files])){
						$ImageNames = array();
						foreach($_FILES as $File){
							if($File["error"] == 0){
								$Image = $File;
								if($Image["type"] == "image/jpeg" or $Image["type"] == "image/jpg" or $Image["type"] == "image/pjpeg"){
									$Uzanti = ".jpg";
								}
								else if($Image["type"] == "image/png"){
									$Uzanti = ".png";
								}
								else{
									return false;
								}
								$FileName = $this->CreateFileName().$Uzanti;
								$Copy = copy($File["tmp_name"],APPLICATION_PATH."/Front/images/".$FileName);
								if($Copy){
									array_push($ImageNames, $FileName);
									if($Settings){
										$Settings->SaveImage($FileName.$Uzanti);
									}
									$this->insert("high_post_images",false,"'','$PostId','$FileName','$ImageType'");
								}
								else{
									$this->ErrorCode = 7;
									$this->Error = "This image cant loaded.[ ".$File["name"]." ]";
								}
							}
						}
						return $ImageNames;
					}
					else{
						return false;
					}
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function CreateFileName(){
			$FileName = rand(100000,999999);
			if(file_exists(APPLICATION_PATH."/Front/images/".$FileName.".png") or file_exists(APPLICATION_PATH."/Front/images/".$FileName.".jpg")){
				return $this->CreateFileName();
			}
			else{
				return $FileName;
			}
		}
		function GetPosts($Features = array(), $Sort = "ASC"){
			/*
				Example array:
				array(
					"PostId" => array(),
					"Like" => array(),
					"Tags" => array(),
					"UserId" => array(),
					"CategoryId" => array(),
					"Pagination" => array(
						"Limit" => 10, #ex
						"Page" => 3 #ex
					)
				);
			*/
			$Posts = array();
			if(is_array($Features["PostId"])){
				array_merge($Posts,$this->GetPostsFromId($Features["PostId"]));
			}
			if(is_array($Features["Like"])){
				
			}
			for($i=0;$i<count($Features["PostId"]);$i++){
				$Features["PostId"][$i] = "PostId='".$this->Uselib->clean($Features[$i]["PostId"])."'";
			}
		}
		function GetPostsFromId($Ids = array()){
			return array();
		}
		function GetPostsFromLike($Likes = array()){
			return array();
		}
		function GetPostsFromTag($Tags = array()){
			return array();
		} 
		function GetPostFromCategory($CategoryIds =  array()){
			return array();
		}
	}
?>