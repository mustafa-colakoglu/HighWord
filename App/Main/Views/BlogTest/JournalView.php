<section>
	<h2>Gündemdekiler</h2>
	<br/>
	<br/>
	<br/>
	<?php
		for($i=0;$i<count($Tags);$i++){
		?>
		<br/><a href="<?php echo get::site(); ?>/BlogTest/Tag/<?php echo $Tags[$i][0]; ?>">#<?php echo $Tags[$i][0]; ?></a>
		<?php
		}
	?>
</section>