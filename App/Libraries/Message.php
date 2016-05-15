<?php
	use MS\MSModel;
	class Message{
		public $Database;
		function __construct(){
			$this->Database = new MSModel();
		}
		
		function NewSubject($SenderId = false, $ReceiverId = false, $Subject = "", $Info = "",$Date = false){
			if(intval($SenderId) > 0 and intval($ReceiverId) > 0){
				$SenderId = intval($SenderId);
				$ReceiverId = intval($ReceiverId);
				if(!$Date){
					$Date = date("d.m.Y");
				}
				$Time = time();
				$NewSubject = $this->Database->insert("high_message_subjects",false,"'','$Subject','$SenderId','$ReceiverId','1','0','$SenderId','0','0','$Date','$Info',$Time','$Time'");
			}
			return false;
		}
		function NewMessage($SenderId = false,$ReceiverId = false,$Message = "",$SubjectId = false,$Subject = ""){
			$Date = date("d.m.Y");
			$Hour = date("H.i.s");
			$Time = time();
			if(intval($SenderId) > 0 and intval($ReceiverId)> 0 and (intval($SubjectId)> 0 or $Subject != "") and $Message != ""){
				$SenderId = intval($SenderId);
				$ReceiverId = intval($ReceiverId);
				$SubjectId = intval($SubjectId);
				if($Subject != ""){
					$Subject = $this->Database->Uselib->formDataFix($Subject);
				}
				$Message = $this->Database->Uselib->formDataFix($Message);
				if(intval($SubjectId) > 0){
					$Control = $this->Database->select("high_messages_subjects","SubjectId='$SubjectId' and ((SenderId='$ReceiverId' and ReceiverId='$SenderId') or (SenderId='$SenderId' and ReceiverId='$ReceiverId')))");
					if(count($Control) <= 0){
						$SubjectId = 0;
					}
					else{
						$SubjectInfo = $Control[0];
						$SubjectId = $Control[0]["SubjectId"];
						$NewMessage = $this->Database->insert("high_messages_messages",false,"'','$SubjectId','$Message','$SenderId','$ReceiverId','0','0','$Date','$Hour','$Time',''");
						if($SubjectInfo["SenderId"] == $SenderId){
							$this->Database->update("high_messages_subjects","SenderRead='1',ReceiverRead='0',LastSenderId='$SenderId',SenderIsDeleted='0',SenderTime='$Time'","SubjectId='$SubjectId'");
						}
						else{
							$this->Database->update("high_messages_subjects","SenderRead='0',ReceiverRead='1',LastSenderId='$SenderId',ReceiverIsDeleted='0',ReceiverTime='$Time'","SubjectId='$SubjectId'");
						}
					}
				}
				else if($Subject != ""){
					$Control = $this->Database->select("high_messages_subjects","Subject='$Subject'");
					if(count($Subject)> 0){
						$SubjectId = $Control[0]["SubjectId"];
					}
					else{
						$SubjectId = $this->NewSubject($SenderId,$ReceiverId,$Subject,"");
					}
					$SubjectInfo = $this->Database->select("high_messages_subjects","SubjectId='$SubjectId'");
					$NewMessage = $this->Database->insert("high_messages_messages",false,"'','$SubjectId','$Message','$SenderId','$ReceiverId','0','0','$Date','$Hour','$Time',''");
					if($SubjectInfo["SenderId"] == $SenderId){
						$this->Database->update("high_messages_subjects","SenderRead='0',ReceiverRead='1',LastSenderId='$SenderId'","SubjectId='$SubjectId'");
					}
					else{
						$this->Database->update("high_messages_subjects","SenderRead='1',ReceiverRead='0',LastSenderId='$SenderId'","SubjectId='$SubjectId'");
					}
				}
				else{
					return false;
				}
			}
		}
		function GetMessages($SubjectId = false){
			if(intval($SubjectId) > 0){
				$SubjectId = intval($SubjectId);
				return $this->Database->select("high_messages_messages","SubjectId='$SubjectId'");
			}
		}
		function DeleteSubject($SubjectId = false,$UserId = false){
			$SubjectId = intval($SubjectId);
			$UserId = intval($UserId);
			if($SubjectId > 0 and $UserId > 0){
				$SubjectInfo = $this->Database->select("high_messages_subjects","SubjectId='$SubjectId'");
				if($SubjectInfo[0]["SenderId"] == $UserId){
					$this->Database->update("high_messages_subjects","SenderIsDeleted='1'","SubjectId='$SubjectId'");
				}
				else{
					$this->Database->update("high_messages_subjects","ReceiverIsDeleted='1'","SubjectId='$SubjectId'");
				}
				$this->Database->update("high_messages_messages","SenderIsDeleted='1'","SubjectId='$SubjectId' and SenderId='$UserId'");
			}
		}
		function DeleteMessage($MessageId = false,$UserId = false){
			$MessageId = intval($MessageId);
			$UserId = intval($UserId);
			if($MessageId > 0 and $UserId > 0){
				$MessageInfo = $this->Database->select("high_messages_messages","MessageId='$MessageId'");
				if(count($MessageInfo)> 0){
					$MessageInfo = $MessageInfo[0];
					if($MessageInfo["SenderId"] == $UserId){
						$this->Database->update("high_messages_messages","SenderIsDeleted='1'","MessageId='$MessageId'");
					}
					else if($MessageInfo["ReceiverId"] == $UserId){
						$this->Database->update("high_messages_messages","ReceiverIsDeleted='1'","MessageId='$MessageId'");
					}
				}
			}
		}
		function GetMessages($SubjectId = false){
			$SubjectId = intval($SubjectId);
			if($SubjectId > 0){
				return $this->Database->select("high_messages_messages","SubjectId='$SubjectId'","","ORDER BY MessageId DESC");
			}
		}
		function GetNewSubjects($UserId = false){
			$UserId = intval($UserId);
			$array = array();
			if($UserId > 0){
				
			}
		}
	}
?>