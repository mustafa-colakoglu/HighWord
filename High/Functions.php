<?php
	$Functions = array("NewPost","UpdatePost");
	for($i=0;$i<count($Functions);$i++){
		if(file_exists(APPLICATION_PATH."../High/".$Functions[$i].".php")){
			include APPLICATION_PATH."../High/".$Functions[$i].".php";
		}
		else{
			echo "Function Not Found : ".$Functions[$i]."<br/>";
			exit();
		}
	}
?>