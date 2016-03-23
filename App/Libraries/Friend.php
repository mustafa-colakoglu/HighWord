<?php
	use MS\MSModel;
	use MS\MSLoad;
	class Friend{
		private $Database;
		function __construct(){
			$this->Database = new MSModel();
			$this->Database->exec("CREATE TABLE IF NOT EXISTS high_friends(
				FriendId int( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				UserId int(11),
				Who int(11)
			);");
		}
		function AddFriend($UserId = false,$FriendId = false){
			if($UserId and $FriendId){
				if(intval($UserId) > 0 and intval($FriendId) > 0){
					$DoControl = $this->Database->select("high_friends","UserId='$UserId' and Who='$FriendId'");
					if(count($DoControl)<=0){
						$this->Database->insert("high_friends",false,"'','$UserId','$FriendId'");
						return $this->Database->lastInsertId();
					}
				}
			}
			return 0;
		}
		function RemoveFriend($UserId = false, $FriendId = false){
			if($UserId and $FriendId){
				if(intval($UserId) > 0 and intval($FriendId) > 0){
					$this->Database->delete("high_friends","UserId='$UserId' and Who='$FriendId'");
				}
				return false;
			}
			return false;
		}
		function GetFriends($UserId = false){
			if($UserId){
				if(intval($UserId) > 0){
					return $this->Database->select("high_friends","UserId='$UserId'");
				}
			}
			return false;
		}
		function GetPosts($UserId = false){
			if($UserId){
				if(intval($UserId) > 0){
					$MSLoad = new MSLoad;
					$UserIds = array();
					foreach($this->GetFriends($UserId) as $Friend){
						array_push($UserIds,$Friend["Who"]);
					}
					return $MSLoad->model("Post")->GetPosts(array("UserId"=>$UserIds));
				}
				return false;
			}
			return false;
		}
		function Drop(){
			$this->Database->exec("DROP TABLE high_friends");
		}
		function Truncate(){
			$this->Database->exec("TRUNCATE TABLE high_friends");
		}
	}
?>