<?php
	namespace Models;
	use MS\MSModel;
	class CategoryModel extends MSModel{
		function NewCategory($CategoryName = false, $Sub = 0){
			if(is_string($CategoryName)){
				$CategoryName = $this->Uselib->formDataFix($CategoryName);
				if(!is_numeric($Sub)){
					$Sub = 0;
				}
				$this->insert("high_categories",false,"'','$CategoryName','$Sub'");
			}
			return $this->lastInsertId();
		}
		function UpdateCategory($CategoryId = false, $SubString = false, $Value = ""){
			if($CategoryId and is_numeric($CategoryId) and is_string($SubString)){
				if($SubString == "CategoryName" or $SubString == "Sub"){
					$Value = $this->Uselib->formDataFix($Value);
					$this->update("high_categories","$SubString='$Value'","CategoryId='$CategoryId'");
				}
			}
		}
		function GetCategories($Sub = "*"){
			if($Sub == "*"){
				return $this->select("high_categories");
			}
			return $this->select("high_categories","Sub='$Sub'");
		}
		function DeleteCategory($CategoryId = false){
			if($CategoryId and is_numeric($CategoryId)){
				$this->delete("high_categories","CategoryId='$CategoryId'");
				$this->delete("high_categories","Sub='$CategoryId'");
			}
		}
	}
?>