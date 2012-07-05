<div class="profile-box rounded">
	<div class="picture-box shadow">
		<?php echo @$picture; ?>
	</div>
	<div class="data-box">
		<div class="profil-label">Nama</div>
		<div class="my-data"><?php echo $myprofiles->first_name.' '.$myprofiles->last_name; ?></div>
		<div class="profil-label">NIS</div>
		<div class="my-data"><?php echo $profiles->id_number; ?></div>
		<div class="profil-label">Kelas</div>
		<div class="my-data"><?php echo $myprofiles->grade.' - '.$myprofiles->class_name; ?></div>
		<div class="pic-button"><?php echo anchor('admin/school/students/picture/'.$myprofiles->user_id, 'Ganti Foto') ?></div>	
	</div>
	<div class="clear"></div>
</div>


<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
<div class="tabs">
    <ul class="tab-menu">
        <li><a href="#profile">Profile</a></li>
        <li><a href="#mydata">Edit data pribadi</a></li>
		<li><a href="#parentdata">Edit data orang tua</a></li>
    </ul>
    <div id="profile">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Data Pribadi</th>
                </tr>
            </thead>
            <tbody>
                <?php if($mydata): ?>
                <?php $ttl = '';  ?>
                <?php foreach( $mydata as $key=>$val): ?>
                <?php 
                    if ($key == 'tanggal' || $key == 'bulan' || $key == 'tahun') {
                        if ($key == 'tanggal'){$ttl .= $val.' - ';}
                        if ($key == 'bulan'){ $ttl .= $val.' - ';}
                        if ($key == 'tahun'){
                            $ttl .= $val;
                            ?>
                            <tr>
                                <td><div style="text-transform: uppercase; font-weight: bold;">tanggal lahir</div>
                                <br /><?php echo $ttl ?></td>
                            </tr>       
                            <?php
                        }
                    } else {
                ?>
                <tr>
                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div>
                    <br /><?php echo $val ?></td>
                </tr>
                <?php } ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div id="mydata">
        <fieldset>
        <ol>
            <li>
                <label for="tempat lahir">Tempat Lahir</label>
                <?php echo form_input('data[tempat_lahir]',@$mydata['tempat_lahir']); ?>
            </li>
            <li class="even">
                <label for="">Tanggal Lahir</label>
                <select name="data[tanggal]">
                    <?php 
                        for($i=1;$i<=31;$i++) {
                            if ($i == @$mydata['tanggal']) {$tgl = 'selected';}
                            ?><option value="<?php echo $i; ?>" <?php echo @$tgl; ?>><?php echo $i; ?></option><?php
                        }
                    ?>
                </select>
                <select name="data[bulan]">
                    <?php $bln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'); ?>
                    <?php 
                        foreach($bln as $key=>$val) {
                            if ($val == @$mydata['bulan']) {$bulan = 'selected';}
                            ?><option value="<?php echo $val; ?>" <?php echo @$bln; ?>><?php echo $val; ?></option><?php
                        }
                    ?>
                </select>
                <select name="data[tahun]">
                    <?php 
                        
                        for($i=1960;$i<=2010;$i++) {
                            if ($i == @$mydata['tahun']) {$thn = 'selected';}
                            ?><option value="<?php echo $i; ?>" <?php echo @$thn; ?>><?php echo $i; ?></option><?php
                        }
                    ?>
                </select>
            </li>
            <li>
                <label for="data[agama]">Agama</label>
                <?php echo form_input('data[agama]',@$mydata['agama']); ?>
            </li>
            <li class="even">
                <label for="data[golongan_darah]">Gol. Darah</label>
                <select name="data[golongan_darah]">
                    <?php $gol=array('A','AB','B','O'); ?>
                    <?php 
                        foreach($gol as $key=>$val) {
                            if ($val == @$mydata['golongan_darah']) {$goldar = 'selected';}
                            ?><option value="<?php echo $val; ?>" <?php echo @$goldar; ?>><?php echo $val; ?></option><?php
                        }
                    ?>
                </select>
            </li>
            <li>
                <label for="data[alamat1]">Alamat 1</label>
                <?php echo form_textarea('data[alamat1]',@$mydata['alamat1']); ?>
            </li>
            <li class="even">
                <label for="data[alamat2]">Alamat 2</label>
                <?php echo form_textarea('data[alamat2]',@$mydata['alamat2']); ?>
            </li>
            <li>
                <label for="data[telephone]">Telephone</label>
                <?php echo form_input('data[telephone]',@$mydata['telephone']); ?>
            </li>
            <li class="even">
                <label for="data[email]">email</label>
                <?php echo form_input('data[email]',@$mydata['email']); ?>
            </li>
        </ol>
        </fieldset>
    </div>
    <div id="parentdata">
        <fieldset>
        <ol>
            <li>
            <label for="data[nama ayah]">Nama Ayah</label>
            <?php echo form_input('data[nama_ayah]',@$mydata['nama_ayah']); ?>
            </li>
            <li class="even">
                <label for="data[nama ibu]">Nama Ibu</label>
                <?php echo form_input('data[nama_ibu]',@$mydata['nama_ibu']); ?>
            </li>
            <li>
                <label for="data[pekerjaan ayah]">Pekerjaan Ayah</label>
                <?php echo form_input('data[pekerjaan_ayah]',@$mydata['pekerjaan_ayah']); ?>
            </li>
            <li class="even">
                <label for="data[alamat orangtua]">Alamat Orang Tua</label>
                <?php echo form_textarea('data[alamat_orangtua]',@$mydata['alamat_orangtua']); ?>
            </li>
        </ol>
        </fieldset>
    </div>
</div>
<?php echo form_hidden('data[mypicture]',@$mydata['mypicture']); ?>
<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
<?php echo form_close(); ?>