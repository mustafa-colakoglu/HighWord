<?php
	namespace Models\BlogTest;
	use MS\MSModel;
	class PostDetailModel extends MSModel{
		function Post($PostId){
			$data["PostDetail"] = $this->model("Post")->GetPost();
		}
	}
?>