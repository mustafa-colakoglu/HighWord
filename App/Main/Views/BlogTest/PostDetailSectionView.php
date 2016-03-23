<section>
	<?php
		foreach($Post as $p){
		extract($p);
		$Images = $PostObject->GetPostImages($PostId);
		$Tags = $PostObject->GetPostTags($PostId);
		?>
		<h2><?php echo $PostTitle; ?></h2>
		<p><?php echo $Post; ?></p>
		<br/>
		<br/>
		<br/>
		<br/>
		<div class="tags">
		<?php
			$Ekle = "";
			foreach($Tags as $t){
				$Ekle.='<a href="'.get::site().'/BlogTest/Tag/'.$t["Tag"].'">'.$t["Tag"].'</a>,';
			}
			echo trim($Ekle,",");
		?>
		</div>
		<?php
		}
	?>
</section>