<?php
	namespace Models;
	use MS\MSModel;
	use User;
	class PostModel extends MSModel{
		function NewPost($PostUserId = 1, $PostTitle = "", $Post = "", $PostDate = "",$CategoryId = 0){
			$PostTime = time();
			if($PostDate == ""){
				$PostDate = date("d.m.Y");
			}
			$this->insert("high_posts","PostUserId,PostTitle,Post,PostDate,PostTime,CategoryId","'$PostUserId','$PostTitle','$Post','$PostDate','$PostTime','$CategoryId'");
			return $this->lastInsertId();
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
			return false;
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
						$DoControl = $this->select("high_post_tags","PostId='$PostId' and Tag='$Tags'");
						if(count($DoControl)>0){}
						else{
							$Time = time();
							$this->insert("high_post_tags",false,"'','$PostId','$Tags','$Time'");
						}
					}
					else if(is_array($Tags)){
						for($i=0;$i<count($Tags);$i++){
							$Tag = $this->Uselib->formDataFix($Tags[$i]);
							$DoControl = $this->select("high_post_tags","PostId='$PostId' and Tag='$Tag'");
							if(count($DoControl)>0){}
							else{
								$Time = time();
								$this->insert("high_post_tags",false,"'','$PostId','$Tag','$Time'");
							}
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
		function GetPost($PostId = false){
			if($PostId){
				return $this->GetPosts(array("PostId"=>array($PostId)));
			}
			return false;
		}
		function GetPosts($Features = array(),$Sort = array("By" => "PostId","Sort" => "DESC")){
			/*
				Example array: $Features
				array(
					"PostId" => array(),
					"Like" => array(),
					"Tags" => array(),
					"UserId" => array(),
					"CategoryId" => array(),
					"Pagination" => array(
						"Limit" => 10, #example
						"Page" => 3 #example
					)
				);
			*/
			if(isset($Features["PostId"])){
				$PostId = $this->CleanPostId($Features["PostId"]);
				for($i=0;$i<count($PostId);$i++){
					$PostId[$i] = "high_posts.PostId='".$PostId[$i]."'";
				}
				$PostIdImplode = "".implode(" OR ",$PostId)."";
				if($PostIdImplode == ""){
					$PostIdImplode = "high_posts.PostId!='0'"; // For All Posts
				}
			}
			else{
				$PostIdImplode = "high_posts.PostId!='0'";
			}
			$LikeImplode = " high_posts.PostTitle LIKE '%%'";
			if(isset($Features["Like"])){
				$Like = $Features["Like"];
				for($i=0;$i<count($Like);$i++){
					$Like[$i] = "(CONCAT(high_posts.PostTitle,high_posts.Post) LIKE '".$Like[$i]."')";
				}
				$LikeImplode = "".implode(" OR ",$Like)."";
			}
			$TagImplode = "";
			if(isset($Features["Tags"])){
				$Tags = $Features["Tags"];
				for($i=0;$i<count($Tags);$i++){
					$Tags[$i] = "high_post_tags.Tag='".$Tags[$i]."'";
				}
				$TagImplode = "".implode(" OR ",$Tags)."";
			}
			$UserIdImplode = "high_posts.PostUserId!='-1'";
			if(isset($Features["UserId"])){
				$UserIds = $Features["UserId"];
				for($i=0;$i<count($UserIds);$i++){
					$UserIds[$i] = "high_posts.PostUserId='".$UserIds[$i]."'";
				}
				$UserIdImplode = implode(" OR ",$UserIds);
			}
			$CategoryImplode = "high_posts.CategoryId!='-1'";
			if(isset($Features["CategoryId"])){
				$CategoryIds = $Features["CategoryId"];
				for($i=0;$i<count($CategoryIds);$i++){
					$CategoryIds[$i] = "high_posts.CategoryId='".$CategoryIds[$i]."'";
				}
				$CategoryImplode = implode(" OR ",$CategoryIds);
			}
			$Limit = "";
			if(isset($Features["Pagination"])){
				$Pagination = $Features["Pagination"];
				$Start = $Pagination["Page"]*$Pagination["Limit"];
				$Finish = $Pagination["Limit"];
				$Limit = " LIMIT ".$Start.",".$Finish;
			}
			if(!isset($Sort["By"])){
				$Sort["By"] = "PostId";
			}
			if(!isset($Sort["Sort"])){
				$Sort["Sort"] = "DESC";
			}
			switch($Sort["By"]){
				case "PostId": $SortTable="high_posts";break;
				case "PostUserId": $SortTable="high_posts";break;
				case "PostTitle": $SortTable="high_posts";break;
				case "Post": $SortTable="high_posts";break;
				case "PostDate": $SortTable="high_posts";break;
				case "PostTime": $SortTable="high_posts";break;
				case "Tag": $SortTable="high_post_tags";break;
				default:$SortTable="high_posts";break;
			}
			if(!is_array($Features) and is_numeric($Features)){
				$posts = $this->select("high_posts","","","LIMIT ".$Features);
			}
			else if($TagImplode == "" or empty($TagImplode)){
				$posts = $this->select(
					"high_posts",
					$LikeImplode." AND ".$PostIdImplode." AND ".$CategoryImplode." AND ".$UserIdImplode,
					"high_posts.PostId,high_posts.PostUserId,high_posts.PostTitle,high_posts.Post,high_posts.PostDate,high_posts.PostTime",
					"ORDER BY ".$SortTable.".".$Sort["By"]." ".$Sort["Sort"].$Limit
				);
			}
			else{
				$posts = $this->select(
					"high_posts",
					"",
					"high_posts.PostId,high_posts.PostUserId,high_posts.PostTitle,high_posts.Post,high_posts.PostDate,high_posts.PostTime,high_post_tags.TagId,high_post_tags.PostId,high_post_tags.Tag",
					"INNER JOIN high_post_tags ON high_posts.PostId=high_post_tags.PostId AND ".$TagImplode." AND ".$LikeImplode." AND ".$PostIdImplode." AND ".$CategoryImplode." AND ".$UserIdImplode." GROUP BY high_post_tags.PostId ORDER BY ".$SortTable.".".$Sort["By"]." ".$Sort["Sort"].$Limit
				);
			}
			return $posts;
		}
		function GetPostImages($PostId = false){
			if($PostId){
				if(intval($PostId)>0){
					return $this->select("high_post_images","PostId='$PostId'");
				}
				return array();
			}
			return array();
		}
		function GetPostTags($PostId = false){
			if($PostId){
				if(intval($PostId)>0){
					return $this->select("high_post_tags","PostId='$PostId'");
				}
				return array();
			}
			return array();
		}
		function DeletePost($PostId = false){
			if($PostId and is_numeric($PostId)){
				$this->delete("high_posts","PostId='$PostId'");
				$this->delete("high_post_tags","PostId='$PostId'");
				$this->delete("high_post_info","PostId='$PostId'");
				$this->delete("high_post_images","PostId='$PostId'");
				return true;
			}
			return false;
		}
		function CleanPostId($Id = array()){
			if(!is_array($Id)){
				return $this->Uselib->clean($Id);
			}
			else{
				for($i=0;$i<count($Id);$i++){
					$Id[$i] = $this->CleanPostId($Id[$i]);
				}
				return $Id;
			}
		}
	}
?>