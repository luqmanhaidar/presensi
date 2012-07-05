<?php if ($this->controller == 'teacher'): ?>

<div class="profile-box rounded">
	<div class="picture-box shadow" style="padding: 0px 10px 20px 5px;">
		<?php echo @$picture; ?>
	</div>
	<div class="data-box">
		<div class="profil-label"><h4><?php echo $myprofiles->first_name.' '.$myprofiles->last_name; ?></h4></div>
		<div class="my-data"><b>NIP. </b><?php echo @$profiles->id_number; ?></div>
		<!--
		<div class="pic-button"><?php echo anchor('admin/school/teachers/picture/'.$myprofiles->user_id, 'Ganti Foto') ?></div>	
		-->
	</div>
	<div class="clear"></div>
</div>

<?php else : ?>

<h3>Data Siswa</h3>

<div class="profile-box rounded">
	<div class="picture-box shadow" style="padding: 0px 10px 20px 5px;">
		<?php echo @$picture; ?>
	</div>
	<div class="data-box">
		<div class="profil-label">Nama</div>
		<div class="my-data"><?php echo $myprofiles->first_name.' '.$myprofiles->last_name; ?></div>
		<div class="profil-label">NIS</div>
		<div class="my-data"><?php echo @$profiles->id_number; ?></div>
		<div class="profil-label">Kelas</div>
		<div class="my-data"><?php echo $myprofiles->grade.' - '.$myprofiles->class_name; ?></div>
		<!-- <div class="pic-button"><?php echo anchor('admin/school/students/picture/'.$myprofiles->user_id, 'Ganti Foto') ?></div>		-->
	</div>
	<div class="clear"></div>
</div>

<?php endif; ?>

<?php if ($this->method == 'edit_profiles'): ?>
	<?php echo form_open($this->uri->uri_string()); ?>
	<div >
        <table class="front-table rounded">
            <thead>
                <tr>
                    <th>field</th>
                    <th>data</th>
                </tr>
            </thead>
            <tbody>
                <?php if($profiles): ?>
                <?php $ttl = '';  ?>
                <?php foreach(unserialize($profiles->data) as $key=>$val): ?>
                <?php if ($key == 'tanggal'): ?>
                	<tr>
		                <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div></td>
		                <td>
		                <select name="data[tanggal]">
		                    <?php 
		                        for($i=1;$i<=31;$i++) {
		                            if ($i == $val) {$tgl = 'selected';}
		                            ?><option value="<?php echo $i; ?>" <?php echo @$tgl; ?>><?php echo $i; ?></option><?php
		                        }
		                    ?>
		                </select>
		                </td>
		            </tr>
                <?php elseif ($key == 'bulan'): ?>
                	<tr>
	                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div></td>
	                    <td>
	                    <select name="data[bulan]">
		                    <?php $bln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'); ?>
		                    <?php 
		                        foreach($bln as $key=>$vals) {
		                            if ($vals == $val) {$bulan = 'selected';}
		                            ?><option value="<?php echo $vals; ?>" <?php echo @$bln; ?>><?php echo $vals; ?></option><?php
		                        }
		                    ?>
		                </select>
	                    </td>
	                </tr>
                <?php elseif ($key == 'tahun'): ?>
	                <tr>
	                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div></td>
	                    <td>
	                    <select name="data[tahun]">
		                    <?php 
		                        
		                        for($i=1960;$i<=2010;$i++) {
		                            if ($i == $val) {$thn = 'selected';}
		                            ?><option value="<?php echo $i; ?>" <?php echo @$thn; ?>><?php echo $i; ?></option><?php
		                        }
		                    ?>
		                </select>
	                    </td>
	                </tr>
	            <?php elseif ($key == 'golongan_darah'): ?>
	                <tr>
	                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div></td>
	                    <td>
	                    <select name="data[golongan_darah]">
		                    <?php $gol=array('A','AB','B','O'); ?>
		                    <?php 
		                        foreach($gol as $key=>$vals) {
		                            if ($vals == $val) {$goldar = 'selected';}
		                            ?><option value="<?php echo $vals; ?>" <?php echo @$goldar; ?>><?php echo $vals; ?></option><?php
		                        }
		                    ?>
		                </select>
	                    </td>
	                </tr>
                <?php elseif ($key == 'alamat1'): ?>
	                <tr>
	                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div></td>
	                    <td>
	                    	<textarea cols="40" rows="5" name="data[alamat1]"><?php echo $val; ?></textarea>
	                    </td>
	                </tr>
                <?php elseif ($key == 'alamat2'): ?>
	                <tr>
	                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div></td>
	                    <td><textarea cols="40" rows="5" name="data[alamat2]"><?php echo $val; ?></textarea></td>
	                </tr>
                <?php elseif ($key == 'alamat_orangtua'): ?>
	                <tr>
	                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div></td>
	                    <td><textarea cols="40" rows="5" name="data[alamat_orangtua]"><?php echo $val; ?></textarea></td>
	                </tr>
                <?php else: ?>
	                <tr>
	                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div></td>
	                    <td><?php echo form_input('data['.$key.']',$val) ?></td>
	                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <input type="submit" name="submit" value="Simpan">
	<?php echo form_close(); ?>
<?php else: ?>

    <div >
        <table class="front-table rounded">
            <thead>
                <tr>
                    <th>field</th>
                    <th>data</th>
                </tr>
            </thead>
            <tbody>
                <?php if($mydata): ?>
                <?php $ttl = '';  ?>
                <?php foreach($mydata as $key=>$val): ?>
                <?php 
                    if ($key == 'tanggal' || $key == 'bulan' || $key == 'tahun') {
                        if ($key == 'tanggal'){$ttl .= $val.' - ';}
                        if ($key == 'bulan'){ $ttl .= $val.' - ';}
                        if ($key == 'tahun'){
                            $ttl .= $val;
                            ?>
                            <tr>
                                <td><div style="text-transform: uppercase; font-weight: bold;">tanggal lahir</div></td>
                                <td><?php echo $ttl ?></td>
                            </tr>       
                            <?php
                        }
                    } else {
                ?>
                <tr>
                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div></td>
                    <td><?php echo $val ?></td>
                </tr>
                <?php } ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
	<?php if($this->kasta->is_mine($myprofiles->user_id)): ?>
		<?php echo anchor('school/edit_profiles/'.$myprofiles->user_id,'Ubah Profil','class = "mybutton"') ?>
	<?php endif; ?>

<?php endif; ?>