<section>
	<div class="main">
		<div class="sol">
			<ul>
				<li><h4>Kategoriler</h4></li>
				<?php
					foreach($kategoriler as $kat){
					?>
					<li><a href="<?php echo get::site(); ?>/BlogTest/Kategori/<?php echo $kat["CategoryId"]; ?>"><?php echo $kat["CategoryName"]; ?></a></li>
					<?php
					}
				?>
			</ul>
		</div>
		<div class="sag">
			<ul>
			<?php
				foreach($posts as $post){
				?>
				<li>
					<h5><?php echo $post["PostTitle"]; ?></h5>
					<p><?php echo substr($post["Post"],0,30) ?></p>
					<a href="<?php echo get::site(); ?>/BlogTest/PostDetay/<?php echo $post["PostId"]; ?>">Devamını gör</a>
				</li>
				<?php
				}
			?>
			</ul>
			<div class="sayilar">
				<?php
					for($i=0;$i<$toplamsayfa;$i++){
						if($i == $suankisayfa){
						?>
						<a class="aktif" href="<?php echo get::site(); ?>/BlogTest/<?php echo $i; ?>"><?php echo $i+1; ?></a>
						<?php
						}
						else{
						?>
						<a href="<?php echo get::site(); ?>/BlogTest/<?php echo $i; ?>"><?php echo $i+1; ?>
						<?php
						}
					}
				?>
			</div>
		</div>
	</div>
</section>