<?php
	namespace Models;
	use MS\MSModel;
	class CommentModel extends MSModel{
		function NewComment($PostId = false, $UserId = false, $Comment = "", $SubCommentId = 0, $OtherUserInfo = ""){
			if($PostId and !empty($Comment)){
				if(!is_numeric($PostId)){
					return false;
				}
				$Post = count($this->select("high_posts","PostId='$PostId'"));
				if($Post>0){
					if($SubCommentId != 0 and $SubCommentId != "" and is_numeric($SubCommentId)){
						$SubComment = count($this->select("high_comments","CommentId='$SubCommentId' and PostId='$PostId'"));
						if($SubComment<=0){
							return false;
						}
					}
					if($UserId){
						$this->insert("high_comments",false,"'','$PostId','$UserId','$Comment','$SubCommentId','$OtherUserInfo'");
					}
					else{
						if(!empty($OtherUserInfo)){
							$this->insert("high_comments",false,"'','$PostId','0','$Comment','$SubCommentId','$OtherUserInfo'");
						}
						else{
							return false;
						}
					}
				}
			}
			return false;
		}
		function GetComments($PostId = false){
			$PostId = intval($PostId);
			if($PostId>0){
				return $this->select("high_comments","PostId='$PostId'");
			}
			else{
				return array();
			}
		}
		function DeleteComment($CommentId = false){
			if($CommentId and is_numeric($CommentId)){
				$this->delete("high_comments","CommentId='$CommentId'");
			}
		}
	}
?>