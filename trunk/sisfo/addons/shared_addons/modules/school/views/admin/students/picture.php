<script type="text/javascript">
<?php if(isset($ratio) && isset($orig_w) && isset($orig_h) && isset($target_w) && isset($target_h)): ?>
jQuery(document).ready(function($){
	$(function(){
		$('#cropbox').Jcrop({
			aspectRatio: <?php echo $ratio ?>,
			setSelect: [0,0,<?php echo $orig_w.','.$orig_h;?>],
			onSelect: updateCoords,
			onChange: updateCoords
		});
	});
	
	function updateCoords(c)
	{
		showPreview(c);
		$("#x").val(c.x);
		$("#y").val(c.y);
		$("#w").val(c.w);
		$("#h").val(c.h);
	};
			
	function showPreview(coords)
	{
		var rx = <?php echo $target_w;?> / coords.w;
		var ry = <?php echo $target_h;?> / coords.h;
		
		$("#preview img").css({
			width: Math.round(rx*<?php echo $orig_w;?>)+'px',
			height: Math.round(ry*<?php echo $orig_h;?>)+'px',
			marginLeft:'-'+  Math.round(rx*coords.x)+'px',
			marginTop: '-'+ Math.round(ry*coords.y)+'px'
		});
	};
});
<?php endif; ?>
</script>

<style type="text/css">
	#preview
	{
		width: <?php echo $target_w?>px;
		height: <?php echo $target_h?>px;
		overflow:hidden;
	}
</style>

<div class="profile-box rounded">
	<div class="picture-box shadow">
		<?php if (isset($thepicture)):?>
		<div id="preview"><img src="<?php echo $thepicture; ?>" alt="thumb"></div>
		<?php else: ?>
		<?php echo @$picture; ?>
		<?php endif; ?>
	</div>
	<div class="data-box">
		<div class="profil-label">Nama</div>
		<div class="my-data"><?php echo $myprofiles->first_name.' '.$myprofiles->last_name; ?></div>
		<div class="profil-label">NIS</div>
		<div class="my-data"><?php echo $profiles->id_number; ?></div>
		<div class="profil-label">Kelas</div>
		<div class="my-data"><?php echo $myprofiles->grade.' - '.$myprofiles->class_name; ?></div>
	</div>
	<div class="clear"></div>
</div>


		<div id="containerHolder">
			<div id="container">
                <!-- h2 stays for breadcrumbs -->
               
               	
		   		<div id="main" style="padding-bottom:10px;">
					<h3>Upload Foto Siswa</h3>
						<?php if(isset($status)){echo $status;}?>
						
						<?php if(isset($error_notification)){echo $error_notification.'<br /><br />';}?>
						<?php if(isset($thepicture)){echo '<div class="imageborder">Original Picture <br /><br /><img src="'.$thepicture.'" id="cropbox" alt="cropbox"></div>';} ?>
						<?php if(isset($thepicture)){echo '<div style="clear:both; margin-bottom:20px;"></div>';} ?>
						<?php /*
							if(isset($thepicture)){
								echo '
								<div class="imageborder" align="center">
									Image Preview for Feature ( Fixed Size 600 x 400 px ) <br /><br />
									<div id="preview"><img src="'.$thepicture.'" alt="thumb"></div>
								</div><br /><br />';
							} */
						?>
						
						<?php if(isset($form)){echo $form;} ?>
                </div>
				
				
                <!-- // #main -->
                
                <div class="clear"></div>
            </div>
            <!-- // #container -->
            
        </div>	
        <!-- // #containerHolder -->
        