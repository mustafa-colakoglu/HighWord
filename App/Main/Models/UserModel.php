<?php
	namespace Models;
	use MS\MSModel;
	use get;
	use PHPMailer;
	class UserModel extends MSModel{
		public $ErrorCode;
		public $ErrorDetail;
		function NewUser($UserName = false, $Password = false, $Email = false){
			if($UserName and $Password and $Email){
				if($this->CheckUserByUserName($UserName)){
					$this->ErrorDetail = "This user already exist.";
					return false;
				}
				else if($this->CheckUserByEmail($Email)){
					$this->ErrorDetail = "This email already exist.";
					return false;
				}
				else{
					$ActivationCode = $this->CreateActivationCode();
					$this->insert("high_users","UserName,Password,Email,ActivationCode","'$UserName','$Password','$Email','$ActivationCode'");
					if($this->lastInsertId()>0){
						return true;
					}
					else{
						$this->ErrorDetail = "Failed User Adding.";
						return false;
					}
				}
			}
			else{
				$this->Error = "Username or Password or Email dont valid.";
				return false;
			}
		}
		function CheckUserByUserName($UserName = false){
			if($UserName){
				$Control = $this->select("high_users","UserName='$UserName'");
				if(count($Control)>0){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function CheckUserByEmail($Email = false){
			if($Email){
				$Control = $this->select("high_users","Email='$Email'");
				if(count($Control)>0){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function CreateActivationCode($Size = 0){
			$abc = "ABCDEFGHIJKLMNOPRSTUVYZWXQ";
			$numbers = "0123456789";
			$Text = "";
			if($Size == 0){
				$Size = 8; // Default
			}
			for($i=0;$i<=$Size;$i++){
				$Rand1 = rand(0,1);
				if($Rand1 == 0){
					$Text.= $abc[rand(0,strlen($abc)-1)];
				}
				else{
					$Text.= $numbers[rand(0,strlen($numbers)-1)];
				}
			}
			return $Text;
		}
		function RegisterUserInfo($UserId = false,$SubScript = false,$Value = false){
			if($UserId and $SubScript and $Value){
				if($SubScript == "Email" or $SubScript == "Password"){
					$this->update("high_users","$SubScript='$Value'","UserId='$UserId'");
				}
				else{
					if(count($this->select("high_user_info","UserId='$UserId' and SubScript='$SubScript'"))>0){
						$this->update("high_user_info","Value='$Value'","UserId='$UserId' and SubScript='$SubScript'");
					}
					else{
						$this->insert("high_user_info","UserId,SubScript,Value","'$UserId','$SubScript','$Value'");
					}
				}
				return true;
			}
			else{
				return false;
			}
		}
		function UpdateUser($UserId = false, $SubScript = false, $Value = false){
			if($UserId and $SubScript and $Value){
				$this->RegisterUserInfo($UserId,$SubScript,$Value);
			}
		}
		function GetUserInfo($UserId, $SubScript){
			if($UserId and $SubScript){
				if($SubScript == "UserName" or $SubScript == "Email" or $SubScript == "ActivationCode"){
					$Info = $this->select("high_users","UserId='$UserId'","$SubScript");
					if(count($Info)>0){
						return $Info[0][$SubScript];
					}
					else{
						return "";
					}
				}
				else{
					$Info = $this->select("high_user_info","UserId='$UserId' and SubScript='$SubScript'");
					if(count($Info)>0){
						return $Info[0]["Value"];
					}
					else{
						return "";
					}
				}
			}
			return false;
		}
		function IsActivated($UyeId = false){
			if($UyeId){
				$Info = $this->select("high_users","UyeId='$UyeId'","IsActivated");
				if(count($Info)>0){
					return $Info[0]["IsActivated"];
				}else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function IsBanned($UyeId = false){
			if($UyeId){
				$Info = $this->select("high_users","UyeId='$UyeId'","IsBanned");
				if(count($Info)>0){
					return $Info[0]["IsBanned"];
				}else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function GetActivationCode($UyeId = false){
			if($UyeId){
				$Info = $this->select("high_users","UyeId='$UyeId'","ActivationCode");
				if(count($Info)>0){
					return $Info[0]["ActivationCode"];
				}else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function PostActivationCode($UserId = false,$From = "", $Title = false, $LeftText = false, $RightText = false){
			if($UserId){
				$ActivationCode = $this->GetActivationCode($UserId);
				$Email = $this->GetUserInfo($UserId,"Email");
				if(!$From){
					$From = "";
				}
				if($ActivationCode and $Email){
					$Mail = new PHPMailer();
					$Mail->IsSMTP();
					$Mail->SMTPDebug = 0;
					$Mail->DebugOutput = "html";
					$Mail->host = get::Config("Email","SmtpHost");
					$Mail->Port = get::Config("Email","SmtpPort");
					$Mail->SMTPSecure = get::Config("Email","SmtpSecure");
					$Mail->SMTPAuth = true;
					$Mail->Username = get::Config("Email","SmtpUsername");
					$Mail->Password = get::Config("Email","SmtpPassword");
					$Mail->SetFrom($From,$From);
					$Mail->AddAddress($Email,$this->GetUserInfo($UserId,"Username"));
					$Mail->Subject = "Activation Code";
					$Mail->msgHTML($LeftText.$ActivationCode.$RightText);
					if($Mail->send()){
						return true;
					}
					else{
						$this->ErrorCode = 4;
						$this->ErrorDetail = $Mail->ErrorInfo;
						return false;
					}
				}
			}
		}
		function ActivateUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				if($UserId == ""){
					$this->update("high_users","IsActivated='1'","UserId='$UserId'");
				}
			}
			else{
				return false;
			}
		}
		function DeActivateUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				if($UserId == ""){
					$this->update("high_users","IsActivated='0'","UserId='$UserId'");
				}
			}
			else{
				return false;
			}
		}
		function BanUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				if($UserId == ""){
					$this->update("high_users","IsBanned='1'","UserId='$UserId'");
				}
			}
			else{
				return false;
			}
		}
		function UnBanUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				if($UserId == ""){
					$this->update("high_users","IsBanned='0'","UserId='$UserId'");
				}
			}
			else{
				return false;
			}
		}
		function DeleteUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				$this->delete("high_users","UserId='$UserId'");
				$this->delete("high_user_info","UserId='$UserId'");
			}
		}
		function FreezeUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				$this->update("high_users","IsFreeze='1'","UserId='$UserId'");
			}
		}
		function UnFreezeUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				$this->update("high_users","IsFreeze='0'","UserId='$UserId'");
			}
		}
	}
?>