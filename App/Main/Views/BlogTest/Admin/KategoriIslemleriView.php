<section>
	<div class="main">
		<a href="<?php echo get::site(); ?>/BlogTest/Admin"><<</a>
		<form action="" method="post">
			<input type="text" name="yeni"/>
			<select name="alt">
				<option value="0">Alt Kategoriyi Seçin</option>
				<?php
					foreach($Kategoriler as $kat){
					?>
					<option value="<?php echo $kat["CategoryId"]; ?>"><?php echo $kat["CategoryName"]; ?></option>
					<?php
					}
				?>
			</select>
			<input type="submit" value="Kaydet"/>
		</form>
		<form action="" method="post">
			<select name="sil">
				<option value="0">Silinecek Kategoriyi Seçin</option>
				<?php
					foreach($Kategoriler as $kat){
					?>
					<option value="<?php echo $kat["CategoryId"]; ?>"><?php echo $kat["CategoryName"]; ?></option>
					<?php
					}
				?>
			</select>
			<input type="submit" value="Sil"/>
		</form>
	</div>
</section>