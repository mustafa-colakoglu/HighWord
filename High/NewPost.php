<?php
	$Date = date("d.m.Y");
	$Time = time();
	function NewPost($Post = false){
		global $Load;
		if($Post){
			if(is_array($Post)){
				if(isset($Post[0])){
					if(is_array($Post[0])){
						for($i=0; $i<count($Post);$i++){
							NewPost($Post[$i]);
						}
					}
				}
				else{
					$Params = array(
						array(
							"VarName" => "PostUserId",
							"VarType" => "Integer",
							"Default" => 1
						),
						array(
							"VarName" => "PostTitle",
							"VarType" => "String",
							"Default" => ""
						),
						array(
							"VarName" => "Post",
							"VarType" => "String",
							"Default" => ""
						),
						array(
							"VarName" => "PostImage",
							"VarType" => "String",
							"Default" => ""
						),
						array(
							"VarName" => "PostDate",
							"VarType" => "String",
							"Default" => date("d:m:Y")
						),
						array(
							"VarName" => "PostTime",
							"VarType" => "Integer",
							"Default" => time()
						)
					);
					for($i=0;$i<count($Params);$i++){
						if(isset($Post[$Params[$i]["VarName"]])){
							$$Params[$i]["VarName"] = $Post[$Params[$i]["VarName"]];
						}
						else{
							$$Params[$i]["VarName"] = $Params[$i]["Default"];
						}
					}
					$Load->model("Post")->NewPost($PostUserId, $PostTitle, $Post, $PostImage, $PostDate, $PostTime);
				}
			}
			else{}
		}
	}
?>